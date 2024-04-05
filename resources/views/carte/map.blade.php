<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <link rel="stylesheet" href="css/carte.css">

</head>

<button onclick="showLastTemp();">last temp</button>
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

    /**
     * lance un appel ajax pour recup les noms des cours d'eau
     */
    function load() {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        // Ci-dessous on traite la réponse quand elle arrive
                        resolve(JSON.parse(this.responseText)); // Parsez le JSON en un objet JavaScript et résolvez la promesse avec les données
                    } else {
                        reject(new Error('Une erreur s\'est produite. Statut de la requête: ' + this.status));
                    }
                }
            };

            xhr.open('POST', 'php/getFileNameCoursEau.php', true);
            xhr.send();
        });
    }

    function parametrageCoursEau(coursEau) {
        coursEau.setStyle({
            color: "rgba(0,0,0,0.7)",
            weight: 2,
        });

        // evenement au survol sur un cours eau
        coursEau.on("mouseover", function(e) {
            coursEau.setStyle({
                weight: 8,
            });
        });

        // evenement au dé-survol sur un cours eau
        coursEau.on("mouseout", function(e) {
            coursEau.setStyle({
                weight: 2,
            });
        });

        // evenement au click sur un cours eau
        coursEau.on("click", function(e) {
            // zoom global sur le cours eau
            map.fitBounds(e.target.getBounds());
            // zoom de plus en plus sur le cours eau 
            //map.setView(e.latlng, map.getZoom() + 4);
        });
    }

    function ajoutPopUpCoursEau(coursEau) {
        coursEau.bindPopup(
            "<h3>" + getNomCoursEau(coursEau) + "</h3>" +
            "<p>code : " + getIdCoursEau(coursEau) + "</p>"
            //+ "<p> delta : " + tabDeltaCoursEau[fileName.slice(0, -8)] + "</p>"
        );
    }

    function getNomCoursEau(coursEau) {
        var NomEntiteHydrographique;
        coursEau.eachLayer(function(layer) {
            NomEntiteHydrographique = layer.feature.properties.NomEntiteHydrographique;
        });
        return NomEntiteHydrographique;
    }

    function getIdCoursEau(coursEau) {
        var cdEntiteHydrographique;
        coursEau.eachLayer(function(layer) {
            cdEntiteHydrographique = layer.feature.properties.CdEntiteHydrographique;
        });
        return cdEntiteHydrographique;
    }

    function setColorCoursEau(coursEau, color) {
        coursEau.setStyle({
            color: color,
            weight: 2,
        });
    };

    function drawCoursEau(tab_fileNameCoursEau) {
        tab_fileNameCoursEau.forEach(fileNameCoursEau => {
            //console.log(fileNameCoursEau);
            fetch("traceCoursEau/" + fileNameCoursEau)
                .then((response) => response.json())
                .then((fileContent) => {
                    // ajoute le cours d'eau sur la carte
                    var coursEau = L.geoJSON(fileContent).addTo(map);

                    // parametrage de l'affichage du cours eau
                    parametrageCoursEau(coursEau);

                    // ajout du pop up au click sur un cours eau
                    ajoutPopUpCoursEau(coursEau)

                    tab_coursEau.push(coursEau);
                })
                .catch((error) =>
                    console.error(
                        "Erreur lors du chargement du fichier GeoJSON :",
                        error
                    )
                );
        });
    }

    var tab_coursEau = [];

    // on attend que la requette ajax termine
    load().then(function(tab_fileNameCoursEau) {
        //console.log(tab_fileNameCoursEau);
        drawCoursEau(tab_fileNameCoursEau);
    }).catch(function(error) {
        console.error(error);
    });


    // --------------- COLORATION COURS D'EAUX EVOLUTION ---------------

    function getColor(temp, min, max) {
        // pour l'evolution
        if (temp == 999)
            return "rgba(0,0,0,0.4)";

        // Bleu pour les températures inférieures au min
        if (temp < min)
            return 'rgb(0, 0, 255)';

        // Rouge pour les températures supérieures au max
        if (temp > max)
            return 'rgb(255, 0, 0)';

        // Calcul de la proportion entre le bleu et le rouge en fonction de la température
        var ratio = (temp + Math.abs(min)) / (max + Math.abs(min));

        var red = Math.round(255 * ratio);
        var blue = Math.round(255 * (1 - ratio));
        return 'rgb(' + red + ', 0, ' + blue + ')';
    }

    function getDelta(annee1, annee2, code_cours_eau) {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        // Ci-dessous on traite la réponse quand elle arrive
                        resolve(JSON.parse(this.responseText)); // Parsez le JSON en un objet JavaScript et résolvez la promesse avec les données
                    } else {
                        reject(new Error('Une erreur s\'est produite. Statut de la requête: ' + this.status));
                    }
                }
            };

            var params = "annee1=" + annee1 + "&annee2=" + annee2 + "&code_cours_eau=" + code_cours_eau;
            xhr.open('POST', 'php/getDelta.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(params);
        });
    }

    function getLastTemp(code_cours_eau) {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        // Ci-dessous on traite la réponse quand elle arrive
                        resolve(JSON.parse(this.responseText)); // Parsez le JSON en un objet JavaScript et résolvez la promesse avec les données
                    } else {
                        reject(new Error('Une erreur s\'est produite. Statut de la requête: ' + this.status));
                    }
                }
            };

            var params = "code_cours_eau=" + code_cours_eau;
            xhr.open('POST', 'php/getLastTemp.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(params);
        });
    }

    function showEvolution(annee1, annee2) {
        tab_coursEau.forEach(coursEau => {
            // on attend que la requette ajax termine
            getDelta(annee1, annee2, getIdCoursEau(coursEau)).then(function(delta) {
                //console.log(delta);
                setColorCoursEau(coursEau, getColor(delta, -5, 5))
            }).catch(function(error) {
                console.error(error);
            });
        });
    }

    function showLastTemp() {
        tab_coursEau.forEach(coursEau => {
            // on attend que la requette ajax termine
            getLastTemp(getIdCoursEau(coursEau)).then(function(lastTemp) {
                //console.log(lastTemp);
                setColorCoursEau(coursEau, getColor(lastTemp, 0, 30))
            }).catch(function(error) {
                console.error(error);
            });
        });
    }

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
        showEvolution(parseInt(annee1.value), parseInt(annee2.value))
    });

    annee2.addEventListener("click", function() {
        showEvolution(parseInt(annee1.value), parseInt(annee2.value))
    });
</script>