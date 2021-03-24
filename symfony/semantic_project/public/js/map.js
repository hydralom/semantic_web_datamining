let map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 48.852969, lng: 2.349903 },
        zoom: 11,
    });
}
