let layer = L.tileLayer(mapboxUrl, {
    attribution: mapboxAttribution,
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
});

let layerGareWifi = L.layerGroup(allMarkersWG);
let layerGrosTas = L.layerGroup(allMarkersGT);

// let mymap = L.map('mapid').setView([48.852969, 2.349903], 13);
let mymap = L.map('mapid', {
    center: [48.852969, 2.349903],
    zoom: 13,
    layers: [layer, layerGareWifi, layerGrosTas]
});

L.control.layers({"Toutes les gares": layerGrosTas, "Gares Wifi": layerGareWifi}).addTo(mymap);
