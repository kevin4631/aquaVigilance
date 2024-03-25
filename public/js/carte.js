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
        color: "#9a6ce6",// couleur de bordure
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
        fillOpacity:0.2
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

// Chargement des données GeoJSON des régions de France
fetch("data/regionFrance/France.geojson")
    .then((response) => response.json())
    .then((data) => {
        // Création couche pr afficher les régions de France
        geojson = L.geoJson(data, {
            style: style,
            onEachFeature: function (feature, layer) {
                layer.on({
                    click: selection_region,
                });
            }
        }).addTo(map);

    })
    .catch((error) =>
        console.error("Erreur du chargement du fichier GeoJSON :", error)
    );

   
// bouton accueil carte pour recentrer sur la France
L.easyButton(
    "accueil",
    function (btn, map) {
        map.setView([46.6031, 1.8883], 6);
    },
    "Zoom France"
).addTo(map);
