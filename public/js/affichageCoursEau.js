// --------------- AJOUT COURS D'EAUX ---------------

/**
 * lance un appel ajax pour recup les noms des cours d'eau
 */
function getTabFileNameCoursEau() {
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
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

    setColorCoursEau(coursEau, "rgba(0,0,0,0.4)");

    // evenement au survol sur un cours eau
    coursEau.on("mouseover", function (e) {
        coursEau.setStyle({
            weight: 8,
        });
    });

    // evenement au dé-survol sur un cours eau
    coursEau.on("mouseout", function (e) {
        coursEau.setStyle({
            weight: 2,
        });
    });

    // evenement au click sur un cours eau
    coursEau.on("click", function (e) {
        // zoom global sur le cours eau
        map.fitBounds(e.target.getBounds());
        // zoom de plus en plus sur le cours eau 
        //map.setView(e.latlng, map.getZoom() + 4);
    });
}

function ajoutPopUpCoursEau(coursEau) {
    coursEau.bindPopup(
        "<h3>" + getNomCoursEau(coursEau) + "</h3>" +
        "<p>code : " + getCodeCoursEau(coursEau) + "</p>"
        //+ "<p> delta : " + tabDeltaCoursEau[fileName.slice(0, -8)] + "</p>"
    );
}

function getNomCoursEau(coursEau) {
    var NomEntiteHydrographique;
    coursEau.eachLayer(function (layer) {
        NomEntiteHydrographique = layer.feature.properties.NomEntiteHydrographique;
    });
    return NomEntiteHydrographique;
}

function getCodeCoursEau(coursEau) {
    var cdEntiteHydrographique;
    coursEau.eachLayer(function (layer) {
        cdEntiteHydrographique = layer.feature.properties.CdEntiteHydrographique;
    });
    return cdEntiteHydrographique;
}

function setColorCoursEau(coursEau, color) {
    coursEau.setStyle({
        color: color,
        weight: 2,
    });
}

function drawCoursEau(tab_fileNameCoursEau) {
    var tab_coursEau = [];

    tab_fileNameCoursEau.forEach(fileNameCoursEau => {
        //console.log(fileNameCoursEau);
        fetch("traceCoursEau/" + fileNameCoursEau)
            .then((response) => response.json())
            .then((fileContent) => {

                // ajoute le cours d'eau sur la carte
                var coursEau = L.geoJSON(fileContent).addTo(map);

                // parametrage de l'affichage du cours eau
                parametrageCoursEau(coursEau);

                // par defaut coloration avec les dernieres temp affiché
                getLastTemp(getCodeCoursEau(coursEau)).then(function (lastTemp) {
                    //console.log(lastTemp);
                    setColorCoursEau(coursEau, getColor(lastTemp, 0, 30))
                }).catch(function (error) {
                    console.error(error);
                });

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
    return tab_coursEau;
}