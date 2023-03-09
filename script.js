var xmlhttp = new XMLHttpRequest();
var url = "data.php";

xmlhttp.open("GET", url, true);
xmlhttp.send();
var map = L.map('map').setView([36.6338, -4.3994], 4);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var terremotos = JSON.parse(this.responseText);

        terremotos.forEach(element => {
            var marker = L.marker([element['lat'], element['long']]).addTo(map);
            marker.bindPopup("<b>" + element['date'] + " " + element['time'] + "</b><br><a href='" + element['link'] + "' target='_blank'>" + element['location'] + " (" + element['magnitude'] + ")");
        });

    }
};





