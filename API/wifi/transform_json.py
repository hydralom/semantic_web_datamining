import sys
import json
import time
import logging
import requests

"""
API :
https://ressources.data.sncf.com/api/records/1.0/search/
    ?dataset=gares-equipees-du-wifi
    &q=
    &sort=nom_de_la_gare
    &rows=3000

    https://ressources.data.sncf.com/api/records/1.0/search/?dataset=gares-equipees-du-wifi&q=&sort=nom_de_la_gare&rows=3000
"""

url = "https://ressources.data.sncf.com/api/records/1.0/search/?dataset=gares-equipees-du-wifi&q=&sort=nom_de_la_gare&rows=3000"

context = {
    "@vocab": "http://confinos.fr/wifi#",
    "@base": "http://confinos.fr/wifi",
    # fields qu'on garde
    "uic": "@id",
    "nom_de_la_gare": "nom_gare",
    "service_wifi": "wifi_actif"
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

    for wifi in r_json:
        temp = wifi["fields"]
        temp["uic"] = "0087" + temp["uic"]
        data.append(temp)

    time.sleep(2)

    return data


def createJsonLDDict(wifis):
    dico = {"@context": context, "data": []}

    for wifi in wifis:
        dico["data"].append(wifi)

    return dico


def exportDictToJsonFile(dictToExport):
    with open('../A-convert_json-ld_to_rdf/wifi.json', 'w') as fp:
        json.dump(dictToExport, fp)


if __name__ == '__main__':
    logger = createLogger()
    logger.info("START %s", sys.argv[0])

    logger.info("Début du crawling : ==========")
    wifis = getAllData()
    logger.info("Fin du crawling : ==========")
    # print(len(wifis))

    dataToExport = createJsonLDDict(wifis)
    logger.info("Data de l'API converti en DICT ==========")

    exportDictToJsonFile(dataToExport)
    logger.info("DICT exporté dans result.json ==========")

    logger.info("END %s", sys.argv[0])
