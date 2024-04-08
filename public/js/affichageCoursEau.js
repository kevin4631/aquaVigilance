// --------------- AJOUT COURS D'EAUX ---------------
function getDefaultWeightCoursEau() {
    return 2;
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
        setWeightCoursEau(coursEau, weightCoursEau);
    });

    // evenement au click sur un cours eau
    coursEau.on("click", function (e) {
        // zoom global sur le cours eau
        //map.fitBounds(e.target.getBounds());
        // zoom de plus en plus sur le cours eau 
        map.setView(e.latlng, map.getZoom() + 1);
    });
}

function setPopUpCoursEau(coursEau, message) {
    let code = getCodeCoursEau(coursEau);
    let current_conseils = myconseils[code];

    let conseils_data =
        "<ul style='list-style-type: none; margin: 0; padding: 0;'><hr>";
    current_conseils.forEach((conse) => {
        conseils_data +=
            "<li style='margin: 0; padding: 0; text-align: justify;'>" +
            conse.description +
            "</li><hr>";
    });
    conseils_data += "</ul>";

    coursEau.bindPopup(
        "<h3>" +
            getNomCoursEau(coursEau) +
            "</h3>" +
            "<p>" +
            message +
            "</p>" +
            "<p>code du cours eau : " +
            getCodeCoursEau(coursEau) +
            "</p>" +
            `<button id="btn_conseils_` +
            code +
            `" onclick='show_conseils("conseils_` +
            code +
            `")' style='display: block; margin: 0 auto; background-color: #4DC3FA; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-style: bold; font-size: 12px; cursor: pointer;'>Conseils</button>` +
            "<div id='conseils_" +
            code +
            "' style='display: none; height: 150px; overflow-x: hidden; margin: 0; padding: 10px 0;'>" +
            conseils_data +
            "</div>"
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

function setWeightCoursEau(coursEau, weight) {
    // mets à jour la var global 
    weightCoursEau = weight;
    coursEau.setStyle({
        weight: weight,
    });
}

function setColorCoursEau(coursEau, color) {
    coursEau.setStyle({
        color: color,
        weight: weightCoursEau,
    });
}

function drawCoursEau(tab_codeCoursEau) {
    var tab_coursEau = [];

    tab_codeCoursEau.forEach(codeCoursEau => {
        //console.log(codeCoursEau);
        fetch("traceCoursEau/" + codeCoursEau + ".geojson")
            .then((response) => response.json())
            .then((fileContent) => {

                // ajoute le cours d'eau sur la carte
                var coursEau = L.geoJSON(fileContent).addTo(map);

                // parametrage de l'affichage du cours eau
                parametrageCoursEau(coursEau);

                // par defaut coloration avec les dernieres temp affiché
                getLastTemp(getCodeCoursEau(coursEau)).then(function (lastTemp) {
                    //console.log(lastTemp);
                    setColorCoursEau(coursEau, getColor(lastTemp["resultat"], 0, 30));
                    setPopUpCoursEau(coursEau, "Derniére température enregistré : " + lastTemp["resultat"].toFixed(2) + "°C"
                        + "<br>le " + lastTemp["date_mesure_temp"] + " à " + lastTemp["heure_mesure_temp"]);
                }).catch(function (error) {
                    console.error(error);
                });

                // ajout du pop up au click sur un cours eau
                setPopUpCoursEau(coursEau, "chargement..");

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