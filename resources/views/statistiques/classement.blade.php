<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des régions</title>

    <style>
        body {
            margin: 0px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: black;
        }

        #evo {
            display: none;
            height: 600px;
            width: 400px;
            position: absolute;
            top: 110px;
            right: 100px;
            z-index: 999;
            border-radius: 16px;
            border: 0;
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%), 0 -1px 0px rgb(0 0 0 / 2%);
            color: #202124;
            background-color: #ffffff;
            padding: 30px 10px 30px 10px;
        }

        #myChart {
            height: 400px;
        }

        #checkboxEvo {
            position: absolute;
            top: 60px;
            right: 100px;
            z-index: 999;
            border-radius: 16px;
            border: 0;
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%), 0 -1px 0px rgb(0 0 0 / 2%);
            color: #202124;
            padding: 2px 10px 2px 10px;
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div id="checkboxEvo">
        <label for="checkbox">Evolution région</label>
        <input type="checkbox" id="checkbox" onchange="afficheEvo()">
    </div>

    <div id="evo">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/evolution.js"></script>

    <script>
        function afficheEvo() {
            var elem = document.querySelector('#evo');
            elem.style.display = document.getElementById('checkbox').checked ? 'inline' : 'none';
        }

        const regions = {
            11: "Île-de-France",
            24: "Centre-Val de Loire",
            27: "Bourgogne-Franche-Comté",
            28: "Normandie",
            32: "Hauts-de-France",
            44: "Grand Est",
            52: "Pays de la Loire",
            53: "Bretagne",
            75: "Nouvelle-Aquitaine",
            76: "Occitanie",
            84: "Auvergne-Rhône-Alpes",
            93: "Provence-Alpes-Côte d'Azur",
            94: "Corse"
        };


        var annee1 = 2010;
        var annee2 = 2020;

        var tab_delta = [];
        var tab_Region = [];

        getDeltaRegion(annee1, annee2).then(function(tab_deltaRegion) {
            console.log(tab_deltaRegion);

            tab_deltaRegion.forEach(deltaRegion => {
                tab_Region.push(regions[deltaRegion[0]]);
                tab_delta.push(deltaRegion[1]);
            });
            console.log(tab_delta);
            console.log(tab_Region);

            drawGraphique();
        }).catch(function(error) {
            console.error(error);
        });


        function drawGraphique() {
            const ctx = document.getElementById('myChart');

            const data = {
                labels: tab_Region,
                datasets: [{
                    data: tab_delta,
                    borderColor: 'rgba(255,0,0,1)',
                    backgroundColor: 'rgba(255,0,0,0.5)',
                }]
            };

            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    indexAxis: 'y',
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        bar: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'evolution'
                        }
                    },
                    scales: {
                        x: {
                            min: -5,
                            max: 5
                        }
                    },
                    maintainAspectRatio: false,
                },
            });
        }
    </script>
</body>

</html>