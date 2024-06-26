<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaVigilance</title>

    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">

    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/carte.css" />
    <link rel="stylesheet" href="css/classement.css" />
    <link rel="stylesheet" href="css/avis.css" />

    <style>
        body {
            margin: 0px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
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

    <div id="checkboxEvo">
        <label class="pointer" for="checkbox">Classement régions</label>
        <input class="pointer" type="checkbox" id="checkbox" onchange="afficheEvo()">
    </div>

    <div id="evo">
        <canvas id="myChart"></canvas>
        <div class="center">
            <a id="BoutonEvo" href="{{ route('evolution') }}" target="_blank">Voir les évolutions</a>
        </div>
    </div>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="avis">
        Trouver vous ce site utile ?
        <img id="oui" src="img/oui.png" alt="oui">
        <img id="non" src="img/non.png" alt="non">
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


    <!--------------- Script qui gere la carte --------------->
    <script src="js/carte.js"></script>
    <!--------------- recupere tous les codes cours eau --------------->
    <script src="js/getAllCodeCoursEau.js"></script>
    <!--------------- gere le traçage des cours eau --------------->
    <script src="js/affichageCoursEau.js"></script>
    <!--------------- gere le traçage des regions --------------->
    <script src="js/affichageRegion.js"></script>
    <!--------------- gere la heat map (coloration des traces) --------------->
    <script src="js/colorationCoursEau.js"></script>
    <!--------------- fonctions pour l'évolution des temperatures --------------->
    <script src="js/evolution.js"></script>
    <!--------------- recupere les temperatures les plus recentes --------------->
    <script src="js/getLastTemp.js"></script>
    <!--------------- gere le classement des regions --------------->
    <script src="js/classement.js"></script>
    <!--------------- api graphique --------------->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--------------- gere le pop up avis --------------->
    <script src="js/avis.js"></script>


    <script>
        /* --------------- AJOUT COURS D'EAUX --------------- */

        //recup la largeur des cours eau
        var weightCoursEau = getDefaultWeightCoursEau();
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
            loadGraphique(parseInt(annee1.value), parseInt(annee2.value));
            showEvolution(parseInt(annee1.value), parseInt(annee2.value), tab_coursEau)
        });

        annee2.addEventListener("click", function() {
            loadGraphique(parseInt(annee1.value), parseInt(annee2.value));
            showEvolution(parseInt(annee1.value), parseInt(annee2.value), tab_coursEau)
        });


        /* --------------- CLASSEMENT --------------- */

        var myChart = null;
        loadGraphique(2010, 2020);
    </script>

    <script>
        var myconseils = <?php echo json_encode($conseils); ?>;
        //console.log(myconseils);

        show_conseils = (code) => {
            if (document.querySelector("#" + code).style.display == 'block') {
                document.querySelector("#btn_" + code).textContent = "Afficher les conseils",
                    document.querySelector("#" + code).style.display = 'none';
            } else {
                document.querySelector("#btn_" + code).textContent = "Masquer les conseils",
                    document.querySelector("#" + code).style.display = 'block';
            }
        }
    </script>
</body>

</html>