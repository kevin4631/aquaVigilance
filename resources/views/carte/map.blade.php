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

    #choixannee {
        position: absolute;
        top: 70px; /* Définir la position à 50px du haut */
        left: 50%; /* Centre horizontalement */
        transform: translateX(-50%); /* Centre horizontalement */
        text-align: center;
        z-index: 999;
    }

    .anneeLabel {
        margin-top: 10px;
        display: inline-block;
        width: 50px; /* Ajustez la largeur selon vos besoins */
    }
</style>

<div id="choixannee">
    <form action="#">
        <input id="size" type="range" min="2006" max="2023" value="2010">
        <div class="anneeLabel">2010</div>
        <input id="size2" type="range" min="2011" max="2023" value="2020">
        <div class="anneeLabel">2020</div>
    </form>
</div>

<script>
var sizeInput = document.getElementById("size");
var size2Input = document.getElementById("size2");

sizeInput.addEventListener("input", function() {
    var currentValue = parseInt(sizeInput.value);
    size2Input.min = currentValue + 1;
});

document.querySelectorAll('input[type="range"]').forEach(function(input) {
    input.addEventListener("input", function() {
        var label = this.nextElementSibling;
        label.innerText = this.value;
    });
});

</script>


<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    const map = L.map("map").setView([46.6031, 1.8883], 6);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    }).addTo(map);

    L.Control.geocoder().addTo(map);

    // --------------- RECUP TEMPERATURE COURS D'EAUX ---------------
    var tabDeltaCoursEau;

    /** 
     * lance un appel ajax pour recup les delta des cours d'eau
     */
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Ci-dessous on traite la réponse quand elle arrive
            tabDeltaCoursEau = JSON.parse(this.responseText); // Parsez le JSON en un objet JavaScript
            // une fois les données recup on lance le chargement des cours d'eau
            load();
        } else if (this.readyState == 4) {
            alert(this.status);
        }
    };

    xhr.open('POST', 'php/getDelta.php', true);
    xhr.send();

    // --------------- AJOUT TRACES COURS D'EAUX ---------------
    var tabFileNameTraceCoursEau;

    /**
     * lance un appel ajax pour recup les noms des cours d'eau
     */
    function load() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Ci-dessous on traite la réponse quand elle arrive
                tabFileNameTraceCoursEau = JSON.parse(this.responseText); // Parsez le JSON en un objet JavaScript
                // un fois les noms recup on affiche les traces
                ajoutTraceCoursEau();
            } else if (this.readyState == 4) {
                alert(this.status);
            }
        };

        xhr.open('POST', 'php/getFileNameCoursEau.php', true);
        xhr.send();
    }

    /** affiche les cours d'eau sur la carte*/
    function ajoutTraceCoursEau() {
        // pour chaque cours d'eau
        tabFileNameTraceCoursEau.forEach(fileName => {
            fetch('traceCoursEau/' + fileName)
                .then(response => response.json())
                .then(fileContent => {

                    // ajout d'un cours d'eau sur la carte
                    var layer = L.geoJSON(fileContent, {
                        style: function(feature) {
                            var color;
                            var weight = 2;

                            if (tabDeltaCoursEau[fileName.slice(0, -8)] > 0) {
                                color = 'red';
                            } else if (tabDeltaCoursEau[fileName.slice(0, -8)] < 0) {
                                color = 'blue';
                            } else {
                                color = 'rgba(0,0,0,0.3)';
                            }

                            return {
                                color: color,
                                weight: weight
                            };

                        }
                    }).addTo(map);

                    // ajout d'un pop up au clique
                    layer.bindPopup('<h3>' + fileContent['features'][0]['properties']['NomEntiteHydrographique'] + '</h3>' +
                        '<p>code : ' + fileContent['features'][0]['properties']['CdEntiteHydrographique'] + '</p>' +
                        '<p> delta : ' + tabDeltaCoursEau[fileName.slice(0, -8)] + '</p>');
                })
                .catch(error => console.error('Erreur lors du chargement du fichier GeoJSON :', error));
        });
    }
</script>