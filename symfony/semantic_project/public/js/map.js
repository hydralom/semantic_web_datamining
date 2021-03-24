let mymap = L.map('mapid').setView([48.852969, 2.349903], 13);
let TOKEN = "pk.eyJ1IjoiaHlkcmFsb20iLCJhIjoiY2ttbmh1NXlkMHg5aTJ3cnp2dG1rdGg2ZiJ9.Z_qMKJirk-b9Mm7jEjE1Aw";

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='+TOKEN, {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: TOKEN
}).addTo(mymap);
