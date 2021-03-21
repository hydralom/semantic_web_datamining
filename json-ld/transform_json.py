import sys
import json
import time
import logging
import requests

"""
API :
https://ressources.data.sncf.com/api/records/1.0/search/
    ?dataset=referentiel-gares-voyageurs
    &q=
    &rows=200
    &sort=gare_alias_libelle_noncontraint
    &refine.gare_regionsncf_libelle=REGION+DE+PARIS-NORD

NB results : 401
"REGION DE PARIS-NORD"  ==> 148
"REGION DE PARIS-SUD-EST"  ==> 96
"REGION DE PARIS SAINT-LAZARE"  ==> 91
"REGION DE PARIS-EST"  ==> 66
"""

regions = ["REGION+DE+PARIS-NORD",
           "REGION+DE+PARIS-SUD-EST",
           "REGION+DE+PARIS SAINT-LAZARE",
           "REGION+DE+PARIS-EST"]

url = "https://ressources.data.sncf.com/api/records/1.0/search/?dataset=referentiel-gares-voyageurs&q=&rows=200&refine.gare_regionsncf_libelle="

context = {
    "@vocab": "http://confinos.fr/",
    "code": "@id",
    # "uic_code": "@id",
    "@type": "TrainStation",
    "longitude_entreeprincipale_wgs84": "string",
    "latitude_entreeprincipale_wgs84": "string",
    # "code": "string",
    "uic_code": "string",
    "commune_libellemin": "string",
    "commune_code": "string",
    "departement_libellemin": "string",
    "departement_numero": "string",
    "adresse_cp": "string",
    "gare_regionsncf_libelle": "string",
    # fields en trop
    "wgs_84": "null",
    "gare": "null",
    "gare_ut_libelle": "null",
    "tvs": "null",
    "tvss": "null",
    "gare_alias_libelle_noncontraint": "null",
    "segmentdrg_libelle": "null",
    "gare_etrangere_on": "null",
    "niveauservice_libelle": "null",
    "gare_drg_on": "null",
    "gare_agencegc_libelle": "null",
    "gare_alias_libelle_fronton": "null",
    "alias_libelle_noncontraint": "null",
    "gare_ug_libelle": "null",
    "rg_libelle": "null",
    "gare_nbpltf": "null",
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
    with open('./result.json', 'w') as fp:
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
