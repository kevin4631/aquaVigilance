<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <link rel="stylesheet" href="css/carte.css">

</head>

<button onclick="showLastTemp(tab_coursEau);">last temp</button>
<div id="choixannee">
    <form action="#">
        <input id="annee1" type="range" min="2006" max="2019" value="2010">
        <div id="annee1label">2010</div>

        <input id="annee2" type="range" min="2007" max="2023" value="2020">
        <div id="annee2label">2020</div>
    </form>
</div>


<div id="map">
    <div id="box">
        <div class="caree bleu"></div>
        <span>
            < 20°C</span>
                <br>
                <div class="caree orange"></div>
                <span>> 30°C</span>
                <br>
                <div class="caree rouge"></div>
                <span>> 40°C</span>
    </div>
</div>


<!--------------- Récupération de la carte leaflet--------------->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!--------------- Barre de recherche--------------->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!--------------- easybutton plugin pour mon bouton acceuil--------------->
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>


<script src="js/affichageCoursEau.js"></script>
<script src="js/colorationCoursEau.js"></script>
<script src="js/getDelta.js"></script>
<script src="js/getLastTemp.js"></script>

<script>
    const map = L.map("map", {
        maxBounds: [
            [41.3, -5], // Coin sud-ouest de la France (ajustement légèrement à gauche)
            [51.1, 9.8], // Coin nord-est de la France (ajustement légèrement à droite)
        ],
        minZoom: 6,
    });

    map.setView([46.6031, 1.8883], 6);

    L.tileLayer("https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png", {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    //barre de recherche
    L.Control.geocoder().addTo(map);


    //coloration toutes les régions
    function style(feature) {
        return {
            color: "#9a6ce6", // couleur de bordure
            weight: 1.8,
            fillOpacity: 0
        };
    }

    // Fonctions pour colorer les régions sélectionné
    let regioncoloree = null;

    function coloration_region(e) {
        let layer = e.target;
        layer.setStyle({
            weight: 1.5,
            fillColor: "red",
            weight: 1.5,
            fillOpacity: 0.2
        });
        layer.bringToFront();

        if (regioncoloree && regioncoloree !== layer) {
            geojson.resetStyle(regioncoloree);
        }
        regioncoloree = layer;
    }

    // pour zoomer lorsque on sélectionne une région
    function selection_region(e) {
        map.fitBounds(e.target.getBounds());
    }

    /*
    // Chargement des données GeoJSON des régions de France
    fetch("data/regionFrance/France.geojson")
        .then((response) => response.json())
        .then((data) => {
            // Création couche pr afficher les régions de France
            geojson = L.geoJson(data, {
                style: style,
                onEachFeature: function(feature, layer) {
                    layer.on({
                        click: selection_region,
                    });
                }
            }).addTo(map);

        })
        .catch((error) =>
            console.error("Erreur du chargement du fichier GeoJSON :", error)
        );

    */
    // bouton accueil carte pour recentrer sur la France
    L.easyButton(
        "accueil",
        function(btn, map) {
            map.setView([46.6031, 1.8883], 6);
        },
        "Zoom France"
    ).addTo(map);


    // --------------- AJOUT COURS D'EAUX ---------------

    // tableau qui va contenir tout les cours d'eau afficher sur la map
    var tab_coursEau;

    // on attend que la requette ajax termine
    getTabFileNameCoursEau().then(function(tab_fileNameCoursEau) {
        //console.log(tab_fileNameCoursEau);
        tab_coursEau = drawCoursEau(tab_fileNameCoursEau);
    }).catch(function(error) {
        console.error(error);
    });

    // --------------- GESTION CURSOR ---------------

    var annee1 = document.getElementById("annee1");
    var annee2 = document.getElementById("annee2");

    annee1.addEventListener("input", function() {
        var annee1Value = parseInt(annee1.value);
        var annee2Value = parseInt(annee2.value);
        annee2.min = annee1Value + 1;
        document.getElementById("annee1label").innerHTML = annee1Value;
    });

    annee2.addEventListener("input", function() {
        var annee1Value = parseInt(annee1.value);
        var annee2Value = parseInt(annee2.value);
        annee1.max = annee2Value - 1;
        document.getElementById("annee2label").innerHTML = annee2Value;
    });

    annee1.addEventListener("click", function() {
        showEvolution(parseInt(annee1.value), parseInt(annee2.value), tab_coursEau)
    });

    annee2.addEventListener("click", function() {
        showEvolution(parseInt(annee1.value), parseInt(annee2.value), tab_coursEau)
    });
</script>