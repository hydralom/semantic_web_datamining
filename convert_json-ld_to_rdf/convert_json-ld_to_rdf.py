from rdflib import Graph

file = open("./json-ld_toConvert.json", "r").read()

graph = Graph().parse(data=file, format='json-ld')

rdf = graph.serialize(format='turtle', indent=4)

with open('./result.ttl', 'wb') as fp:
    fp.write(rdf)

print('Done.')
