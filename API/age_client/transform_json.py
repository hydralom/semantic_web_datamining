import sys
import json
import time
import logging
import requests

"""
API :
https://ressources.data.sncf.com/api/records/1.0/search/
    ?dataset=enquetes-gares-connexions-repartition-repartition-par-classe-dage
    &q=
    &rows=400
    &sort=gare_enquetee

"""

url = "https://ressources.data.sncf.com/api/records/1.0/search/?dataset=enquetes-gares-connexions-repartition-repartition-par-classe-dage&q=&rows=400&sort=gare_enquetee"

context = {
    "@vocab": "http://confinos.fr/Age_client_par_gare#",
    "@base": "http://confinos.fr/Age_client_par_gare",
    # fields qu'on garde
    "uic":"@id",
    "classe_d_age":"tranche_age",
    "annee":"record_year",
    "pourcentage":"pourcentage",
    "gare_enquetee":"nom_gare"
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

    response = requests.request("GET", url)

    logger.info("Call api %s return %s status" % (response.url, response.status_code))

    r_json = response.json()
    r_json = r_json["records"]

    for age_client in r_json:
        temp = age_client["fields"]
        data.append(temp)

    return data


def createJsonLDDict(age_clients):
    dico = {"@context": context, "data": []}

    for age_client in age_clients:
        dico["data"].append(age_client)

    return dico


def exportDictToJsonFile(dictToExport):
    with open('../A-convert_json-ld_to_rdf/age_client.json', 'w') as fp:
        json.dump(dictToExport, fp)


if __name__ == '__main__':
    logger = createLogger()
    logger.info("START %s", sys.argv[0])

    logger.info("Début du crawling : ==========")
    age_clients = getAllData()
    logger.info("Fin du crawling : ==========")
    # print(len(age_clients))

    dataToExport = createJsonLDDict(age_clients)
    logger.info("Data de l'API converti en DICT ==========")

    exportDictToJsonFile(dataToExport)
    logger.info("DICT exporté dans result.json ==========")

    logger.info("END %s", sys.argv[0])
