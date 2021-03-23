from rdflib import Graph

tableau = ["trainstation", "handicap"]  # , "accident_travail", "wifi"]

for name in tableau:
    print("start : %s.json" % name)
    file = open("./" + name + ".json", "r").read()

    graph = Graph().parse(data=file, format='json-ld')

    rdf = graph.serialize(format='turtle', indent=4)

    with open('./' + name + '.ttl', 'wb') as fp:
        fp.write(rdf)

print('Done.')
