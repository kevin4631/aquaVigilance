///** affiche les cours d'eau sur la carte*/
function ajoutTraceCoursEau() {
    // pour chaque cours d'eau
    tabFileNameTraceCoursEau.forEach((fileName) => {
        fetch("traceCoursEau/" + fileName)
            .then((response) => response.json())
            .then((fileContent) => {
                // ajout d'un cours d'eau sur la carte
                var layer = L.geoJSON(fileContent, {
                    style: function (feature) {
                        var color;
                        var weight = 1;

                        if (tabDeltaCoursEau[fileName.slice(0, -8)] != null) {
                            color = getColor(
                                tabDeltaCoursEau[fileName.slice(0, -8)]
                            );
                        } else {
                            color = "rgba(0,0,0,0.3)";
                        }

                        return {
                            color: color,
                            weight: weight,
                        };
                    },
                }).addTo(map);

                layer.on("mouseover", function (e) {
                    layer.setStyle({
                        weight: 5,
                    });
                });

                layer.on("mouseout", function (e) {
                    layer.setStyle({
                        weight: 2,
                    });
                });

                layer.on("click", function (e) {
                    map.setView(e.latlng, map.getZoom() + 4);
                });

                // ajout d'un pop up au clique
                layer.bindPopup(
                    "<h3>" +
                        fileContent["features"][0]["properties"][
                            "NomEntiteHydrographique"
                        ] +
                        "</h3>" +
                        "<p>code : " +
                        fileContent["features"][0]["properties"][
                            "CdEntiteHydrographique"
                        ] +
                        "</p>" +
                        "<p> delta : " +
                        tabDeltaCoursEau[fileName.slice(0, -8)] +
                        "</p>"
                );
            })
            .catch((error) =>
                console.error(
                    "Erreur lors du chargement du fichier GeoJSON :",
                    error
                )
            );
    });
}
