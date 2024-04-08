<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaVigilance</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">

    <style>
        body {
            margin: 0px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        header {
            height: 60px;
            width: 98vw;
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(0, 121, 184, 0.9);
            z-index: 999;
            border-radius: 16px;
            border: 0;
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%), 0 -1px 0px rgb(0 0 0 / 2%);
        }

        .logoTitre {
            display: flex;
            align-items: center;
        }

        .boutonHeader {
            margin-right: 70px;
        }

        .logo {
            height: 50px;
            margin-left: 70px;
        }

        .buttonH {
            margin-left: 15px;
            padding: 5px 10px 5px 10px;
            text-decoration: none;
            border-radius: 16px;
            border: 0;
            color: #4DC3FA;
            background-color: #1F2739;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .buttonH:hover {
            color: #fff;
        }

        footer {
            width: 100vw;
            position: absolute;
            bottom: 0;
            left: 0;
            display: flex;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 10px;
            z-index: 999;
        }

        .titre {
            margin: 0px;
            color: #ffffff;
            font-size: 25px;
        }

        .leaflet-top {
            top: 100px;
        }

        .leaflet-left {
            left: 10px;
        }

        .leaflet-right {
            right: 10px;
        }

        #map {
            height: 100vh;
            width: 100vw;

        }

        #param {
            position: absolute;
            top: 110px;
            left: 100px;
            z-index: 999;
            border-radius: 16px;
            border: 0;
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%), 0 -1px 0px rgb(0 0 0 / 2%);
            color: #202124;
            padding: 10px;
            background-color: #ffffff;
        }

        input {
            margin-top: 10px;
        }

        #annee2 {
            margin-left: 10px;
        }

        #annee1label {
            margin-top: 10px;
        }

        #annee2label {
            margin-top: 10px;
        }

        .button {
            position: absolute;
            top: 200px;
            left: 100px;
            z-index: 999;
            height: 30px;
            background-color: #ffffff;
            border: 0;
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%), 0 -1px 0px rgb(0 0 0 / 2%);
            color: #202124;
            cursor: pointer;
            border-radius: 16px;
            padding: 5px 10px 5px 10px;
            font-weight: bold;
        }

        .button:hover {
            background-color: rgb(240, 240, 240);
        }

        p {
            font-weight: bold;
            margin: 0;
        }

        .flex {
            display: flex;
        }

        .leaflet-bar a {
            background-color: #000;
            color: rgb(220, 220, 220);
        }

        .leaflet-bar a:hover {
            background-color: #000;
            color: #fff;
            font-size: 40px;
        }

        .leaflet-bar a.leaflet-disabled {
            background-color: #000;
            color: rgb(120, 120, 120);
        }

        .leaflet-bar a.leaflet-disabled {
            background-color: #000;
            color: rgb(120, 120, 120);
            font-size: 22px;
        }

        .leaflet-touch .leaflet-control-layers,
        .leaflet-touch .leaflet-bar {
            border: none;
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%), 0 -1px 0px rgb(0 0 0 / 2%);
            border-radius: 8px;
        }

        .leaflet-touch .leaflet-bar a {
            border-radius: 8px 8px 8px 8px;
        }

        .leaflet-touch .leaflet-bar a:first-child {
            border-radius: 8px 8px 0 0;
        }

        .leaflet-touch .leaflet-bar a:last-child {
            border-radius: 0 0 8px 8px;
        }

        button[title='Zoom France'] {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }

        button[title='Zoom France']:hover {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }

        button[title='changer le fond de carte'] {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }

        button[title='changer le fond de carte']:hover {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }

        button[title='changer le fond de carte'] span span img:hover {
            margin-left: -1px;
        }

        .leaflet-container .leaflet-control-attribution {
            background-color: rgba(0, 0, 0, 0);
        }

        .leaflet-container .leaflet-control-attribution a {
            color: #fff;
        }

        .leaflet-container .leaflet-control-attribution span {
            color: #fff;
        }

        .leaflet-control-attribution,
        .leaflet-control-scale-line {
            color: #bfe5ff;
        }

        .legend {
            position: absolute;
            bottom: 40px;
            left: 20px;
            z-index: 999;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 16px;
            border: 0;
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%), 0 -1px 0px rgb(0 0 0 / 2%);
            color: #fff;
            padding: 10px;
        }

        .bleu {
            background-color: blue;
        }

        .rouge {
            background-color: red;
        }

        .caree {
            width: 16px;
            height: 16px;
            display: inline-block;
            margin-right: 3px;
        }

        .imgButton {
            margin-top: 6px;
            height: 17px;
        }

        .imgButton:hover {
            margin-top: 3px;
            height: 22px;
        }
    </style>
</head>

<body>

    @include('headfoot/header')

    <button class="button" onclick="showLastTemp(tab_coursEau);">Voir les derniers relevés</button>

    <div id="param">
        <p>Choisir un interval pour voir l'évolution</p>

        <div class="flex">
            <div class="flex">
                <input id="annee1" type="range" min="2006" max="2019" value="2010">
                <p id="annee1label">2010</p>
            </div>

            <div class="flex">
                <input id="annee2" type="range" min="2011" max="2023" value="2020">
                <p id="annee2label">2020</p>
            </div>
        </div>
    </div>

    <div class="legend">
        <div class="caree rouge"></div>
        <span id="max"> ⩾ 30°C</span>
        <br>
        <div class="caree bleu"></div>
        <span id="min">
            ⩽ 0°C</span>
    </div>


    <div id="map">
    </div>

    @include('headfoot/footer')

    <!--------------- Récupération de la carte leaflet--------------->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!--------------- Barre de recherche--------------->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!--------------- easybutton plugin pour mon bouton acceuil--------------->
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>


    <script src="js/carte.js"></script>
    <script src="js/getAllCodeCoursEau.js"></script>
    <script src="js/affichageCoursEau.js"></script>
    <script src="js/affichageRegion.js"></script>
    <script src="js/colorationCoursEau.js"></script>
    <script src="js/evolution.js"></script>
    <script src="js/getLastTemp.js"></script>

    <script>
        /* --------------- AJOUT COURS D'EAUX --------------- */

        // recup les codes cours eau
        var tab_codeCoursEau = getAllCodeCoursEau();
        // recup et trace les cours d'eau sur la carte
        var tab_coursEau = drawCoursEau(tab_codeCoursEau);

        /* --------------- AJOUT REGION --------------- */

        var region_disable = null;
        // recup et trace les region sur la carte
        var tab_region = drawRegions();;

        /* --------------- EVENEMENT HEAT MAP CARTE --------------- */

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
</body>

</html>