<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />


<style>
    html,
    body {
        height: 91.5%;
        margin: 0;
    }

    h1 {
        text-align: center;
        font-size: 80px;
    }

    .leaflet-container {
        height: 400px;
        width: 600px;
        max-width: 100%;
        max-height: 100%;
        margin: 0 auto;
    }

    #map {
        height: 100%;
        width: 60%;
    }
</style>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<script src="https://unpkg.com/Leaflet.river.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const map = L.map("map").setView([46.6031, 1.8883], 6);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    }).addTo(map);

    L.Control.geocoder().addTo(map);

    // --------------- AJOUT TRACES COURS D'EAUX ---------------

    var xhr = new XMLHttpRequest();
    var tabNameFileTracesCoursEaux;

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Ci-dessous on traitera la réponse quand elle arrivera
            // Parsez le JSON en un objet JavaScript
            tabNameFileTracesCoursEaux = JSON.parse(this.responseText);
            ajoutTracesCoursEaux();
        } else if (this.readyState == 4) {
            alert(this.status);
        }
    };

    xhr.open('POST', 'php/getNameFileTracesCoursEaux.php', true);
    xhr.send();

    function ajoutTracesCoursEaux() {
        tabNameFileTracesCoursEaux.forEach(nameFile => {
            fetch('tracesCoursEaux/' + nameFile)
                .then(response => response.json())
                .then(contentFile => {
                    var layer = L.geoJSON(contentFile).addTo(map);
                    //layer.bindPopup('<h1>' + contentFile['features'][0]['properties']['NomEntiteHydrographique'] + '</h1>' +
                      //  '<p>code_uri: ' + contentFile['features'][0]['properties']['CdEntiteHydrographique'] + '</p>');

                })
                .catch(error => console.error('Erreur lors du chargement du fichier GeoJSON :', error));
        });
    }
</script>