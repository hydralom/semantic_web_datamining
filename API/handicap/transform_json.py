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
    &refine.gare_regionsncf_libelle=REGION+DE+PARIS-NORD
"""

regions = ["REGION+DE+PARIS-NORD",
           "REGION+DE+PARIS-SUD-EST",
           "REGION+DE+PARIS SAINT-LAZARE",
           "REGION+DE+PARIS-EST"]

url = "https://ressources.data.sncf.com/api/records/1.0/search/?dataset=accompagnement-pmr-gares&q=&rows=200&refine.gare_regionsncf_libelle="

context = {
    "@vocab": "http://confinos.fr/disabled_person_helped#",
    "@base": "http://confinos.fr/disabled_person_helped",
    # fields qu'on garde
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

    for region in regions:
        response = requests.request("GET", url + region)

        logger.info("Call api %s return %s status" % (response.url, response.status_code))

        r_json = response.json()
        r_json = r_json["records"]

        for handicap in r_json:
            temp = handicap["fields"]
            data.append(temp)

        time.sleep(1)

    return data


def createJsonLDDict(h):
    dico = {"@context": context, "data": []}

    for handicap in h:
        dico["data"].append(handicap)

    return dico


def exportDictToJsonFile(dictToExport):
    with open('../A-convert_json-ld_to_rdf/handicap.json', 'w') as fp:
        json.dump(dictToExport, fp)


if __name__ == '__main__':
    logger = createLogger()
    logger.info("START %s", sys.argv[0])

    logger.info("Début du crawling : ==========")
    handicaped = getAllData()
    logger.info("Fin du crawling : ==========")
    # print(len(handicaped))

    dataToExport = createJsonLDDict(handicaped)
    logger.info("Data de l'API converti en DICT ==========")

    exportDictToJsonFile(dataToExport)
    logger.info("DICT exporté dans result.json ==========")

    logger.info("END %s", sys.argv[0])
