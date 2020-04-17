
var tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> Contributors'
});
//remember last position
var rememberLat = document.getElementById('appbundle_campement_latitude').value;
var rememberLong = document.getElementById('appbundle_campement_longitude').value;
if( !rememberLat || !rememberLong ) { rememberLat = 36.527294814546; rememberLong =10.5029296875;}
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
map.on('click', function(e){
    $.ajax({ url:'http://api.geonames.org/countryCodeJSON?lat='+e.latlng.lat+'&lng='+e.latlng.lng+'&username=sofien',
        success: function(data){
           // var state = data.results[0].address_components[5].long_name;
            //            // var country = data.results[0].address_components[6].long_name;
            //             //var zip = data.results[0].address_components[7].long_name;
            //            // $('.leaflet-popup-content').text(country+' '+zip);
            console.log(data["countryName"]);
            document.getElementById('appbundle_campement_paye').value=data["countryName"];
        }
    });
   // popup.setLatLng(e.latlng).setContent('').openOn(map);
});