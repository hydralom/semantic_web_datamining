import rdflib
import json
from rdflib import Graph

file = open("./handicaps_tojson_ld.json", "r").read()

graph = Graph().parse(data=file, format='json-ld')

rdf = graph.serialize(format='turtle', indent=4)

with open('./result2.ttl', 'wb') as fp:
    fp.write(rdf)

print('Done.')
