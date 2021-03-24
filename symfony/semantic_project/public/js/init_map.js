let TOKEN = "pk.eyJ1IjoiaHlkcmFsb20iLCJhIjoiY2ttbmh1NXlkMHg5aTJ3cnp2dG1rdGg2ZiJ9.Z_qMKJirk-b9Mm7jEjE1Aw";
let mapboxUrl = "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=" + TOKEN;
let mapboxAttribution = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';

let iconeTrain = L.icon({
    iconUrl: '../img/icon_train.png',
})

let iconeWifi = L.icon({
    iconUrl: '../img/icon_wifi.png',
})
