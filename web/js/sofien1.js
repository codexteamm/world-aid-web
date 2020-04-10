/*let $map = document.querySelector('#map1');

class LeafletMap {
    constructor() {
        this.map=null;
    }

    async load(element) {
        return new Promise((resolve, reject) => {
            $script('https://unpkg.com/leaflet@1.3.1/dist/leaflet.js', function () {
                console.log(element)
                //console.log(L.map(element))
                console.log(this.map)
                this.map = L.map(element)

                resolve()


            })
        })

    }

    addMarker(lat, lng, text) {
        L.popup({
            autoClose: false,
            closeOnEscapeKey: false,
            closeOnClick: false,
            closeButton: false,
            className: 400

        })
            .setLatLng([lat, lng])
            .openOn(this.map)

    }


}

const initMap = async function () {
    let map = new LeafletMap()
    await map.load($map);
    Array.from(document.querySelectorAll('.card').forEach((item) => {
        map.addMarker(item.dataset.lat, item.dataset.lng)
    }))


};
if ($map != null) {
    initMap()
}*/
var map = L.map('map1').setView([36.527294814546,10.5029296875], 9);
L.tileLayer('http://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png').addTo(map); //will be our basemap.
function addpopup(lat,lan,desc){
    console.log(lat , lan , desc)
    map.panTo([lat,lan]);
    L.popup({
        autoClose: false,
        closeOnEscapeKey : false,
        closeOnClick: false,
        closeButton: false,
        className: 'marker',
        maxWidth:400

    })
        .setLatLng([lat, lan])
        .setContent(desc)
        .openOn(map);



}

Array.from(document.querySelectorAll('.card-body')).forEach((item) => {
    //console.log(item.dataset.lat, item.dataset.lng)

    item.addEventListener('click',function () {
        console.log(item.dataset.lat, item.dataset.lng, item.dataset.desc )
        addpopup(item.dataset.lat, item.dataset.lng,item.dataset.desc)


    })
})
$(".filter").on("keyup", function() {
    var input = $(this).val().toUpperCase();

    $(".col-sm-5").each(function() {
        if ($(this).data("string").toUpperCase().indexOf(input) < 0) {
            $(this).hide();
        } else {
            $(this).show();
        }
    })
});
