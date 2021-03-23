import sys
import json
import time
import logging
import requests

"""
API :
https://ressources.data.sncf.com/api/records/1.0/search/
    ?dataset=accompagnement-pmr-gares
    &q=
    &sort=datemensuel
    &facet=datemensuel
    &facet=gare
    &refine.datemensuel=2020%2F11
    &refine.gare_regionsncf_libelle=REGION+DE+PARIS-NORD
"""

dateMensuel = "&refine.datemensuel=2020/"
regions = ["REGION+DE+PARIS-NORD",
           "REGION+DE+PARIS-SUD-EST",
           "REGION+DE+PARIS SAINT-LAZARE",
           "REGION+DE+PARIS-EST"]

url = "https://ressources.data.sncf.com/api/records/1.0/search/?dataset=referentiel-gares-voyageurs&q=&rows=200&refine.gare_regionsncf_libelle="

context = {
    "@vocab": "http://confinos.fr/disabled_person_helped#",
    "@base": "http://confinos.fr/disabled_person_helped",
    "uic": "@id",
    "fauteuil": {
        "@id": "wheelchairs",
        "@type": "https://www.w3.org/2001/XMLSchema#integer"
    },
    "assistance_simple":{
        "@id": "simple_support",
        "@type": "https://www.w3.org/2001/XMLSchema#integer"
    },
    "rampe":{
        "@id": "ramps",
        "@type": "https://www.w3.org/2001/XMLSchema#integer"
    },
    "rampe_fauteuil":{
        "@id": "wheelchairs_on_ramps",
        "@type": "https://www.w3.org/2001/XMLSchema#integer"
    },
    "total": {
        "@id": "helped_disabled_nb",
        "@type": "https://www.w3.org/2001/XMLSchema#integer"
    },
    "datemensuel": "record_month",
    "gare" : "nom_gare"
}


def createLogger():
    log = logging.getLogger('crawler_sncf')
    log.setLevel(logging.DEBUG)
    log.propagate = False

    # create console handler and set level to debug
    ch = logging.StreamHandler()
    ch.setLevel(logging.DEBUG)

    # create formatter
    formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s --> %(message)s')

    # add formatter to ch
    ch.setFormatter(formatter)

    # add ch to logger
    log.addHandler(ch)

    return log


def getAllData():
    data = []

    for i in range(11):
        for region in regions:
            chiffre = i + 1
            response = requests.request("GET", url + region + dateMensuel + str(chiffre))

            logger.info("Call api %s return %s status" % (response.url, response.status_code))

            r_json = response.json()
            r_json = r_json["records"]

            for train_station in r_json:
                temp = train_station["fields"]
                data.append(temp)

            time.sleep(2)

    return data


def createJsonLDDict(tS):
    dico = {"@context": context, "data": []}

    for train_station in tS:
        dico["data"].append(train_station)

    return dico


def exportDictToJsonFile(dictToExport):
    with open('../A-convert_json-ld_to_rdf/handicap.json', 'w') as fp:
        json.dump(dictToExport, fp)


if __name__ == '__main__':
    logger = createLogger()
    logger.info("START %s", sys.argv[0])

    logger.info("Début du crawling : ==========")
    train_stations = getAllData()
    logger.info("Fin du crawling : ==========")
    # print(len(train_stations))  # check if 401 results

    dataToExport = createJsonLDDict(train_stations)
    logger.info("Data de l'API converti en DICT ==========")

    exportDictToJsonFile(dataToExport)
    logger.info("DICT exporté dans result.json ==========")

    logger.info("END %s", sys.argv[0])
