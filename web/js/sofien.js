
var tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> Contributors'
});
//remember last position
var rememberLat = document.getElementById('appbundle_campement_latitude').value;
var rememberLong = document.getElementById('appbundle_campement_longitude').value;
if( !rememberLat || !rememberLong ) { rememberLat = 18.53; rememberLong = 73.85;}
var map = new L.Map('map', {
    'center': [rememberLat, rememberLong],
    'zoom': 12,
    'layers': [tileLayer]
});
var marker = L.marker([rememberLat, rememberLong],{
    draggable: true
}).addTo(map);
marker.on('dragend', function (e) {
    updateLatLng(marker.getLatLng().lat, marker.getLatLng().lng);
});


map.on('click', function (e) {

    marker.setLatLng(e.latlng);
    updateLatLng(marker.getLatLng().lat, marker.getLatLng().lng);




});

function updateLatLng(lat,lng,reverse) {
    if(reverse) {
        marker.setLatLng([lat,lng]);
        map.panTo([lat,lng]);
    } else {
        document.getElementById('appbundle_campement_latitude').value = marker.getLatLng().lat;
        document.getElementById('appbundle_campement_longitude').value = marker.getLatLng().lng;
        map.panTo([lat,lng]);
    }
}