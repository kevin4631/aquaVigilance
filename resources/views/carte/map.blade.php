<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <link rel="stylesheet" href="css/carte.css">
</head>
<body>



<div id="map">

    <div id="choixannee">
        <form action="#">
            <input id="size" type="range" min="2006" max="2023" value="2010">
            <div class="anneeLabel">2010</div>
            <input id="size2" type="range" min="2011" max="2023" value="2020">
            <div class="anneeLabel">2020</div>
        </form>
    </div>
    <div id="box">
        <div class="caree bleu"></div>
        <span> <  20°C</span>
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
<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>

<!--------------- Barre de recherche--------------->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!--------------- easybutton plugin pour mon bouton acceuil--------------->
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

<!--------------- Affichage de la carte --------------->
<script src="js/carte.js"></script>

<!--------------- Traçage cours d'eaux --------------->
<script src="js/tracage_cours_eau.js"></script>

<!--------------- Coloration cours d'eaux --------------->
<script src="js/affichage_cours_eau.js"></script>

<!--------------- Récupération température cours d'eaux --------------->
<script src="js/recuperation_temperature.js"></script>

<!--------------- Coloration cours d'eaux --------------->
<script src="js/coloration_cours_eau.js"></script>
