<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evolution des températures des cours d'eau</title>
    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Evolution des températures des cours d'eau</h1>

    <!-- Partie pour le tableau -->
    <h2>Tableau des moyennes de température par année</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Année</th>
                <th>Moyenne de température</th>
            </tr>
        </thead>
        <tbody id="evolutionTable">
            <!-- Les données seront ajoutées ici dynamiquement -->
        </tbody>
    </table>

    <!-- Partie pour le graphique -->
    <h2>Graphique de l'évolution des températures par année</h2>
    <canvas id="myChart" width="800" height="400"></canvas>

    <script>
        async function getEvolutionCoursEau(annee1, annee2, codeCoursEau) {
            var moyennesParAnnee = {};
            var nbMesuresParAnnee = {};

            try {
                const response = await fetch("data/" + codeCoursEau + ".json");
                const fileContent = await response.json();

                fileContent.forEach(data => {
                    var annee = parseInt(data["date_mesure_temp"].substring(0, 4));
                    var temp = data["resultat"];
                    if (annee >= annee1 && annee <= annee2) {
                        if (!moyennesParAnnee[annee]) {
                            moyennesParAnnee[annee] = 0;
                            nbMesuresParAnnee[annee] = 0;
                        }
                        moyennesParAnnee[annee] += temp;
                        nbMesuresParAnnee[annee]++;
                    }
                });
            } catch (error) {
                console.error("Erreur lors du chargement du fichier JSON :", error);
            }

            // Calculer les moyennes de chaque année
            for (const annee in moyennesParAnnee) {
                moyennesParAnnee[annee] /= nbMesuresParAnnee[annee];
            }

            return moyennesParAnnee;
        }

       

        async function afficherEvolution(tab_codeCoursEau) {
            const codeCoursEau = ['----0010', 'F---0100', 'F24-0400', 'F4--0210', 'F4380600', 'F44-0400', 'F4480600', 'F45-0400', 'F46-0400', 'F46-0420', 'F48-0400', 'F65-0400', 'F70-0400', 'H---0100', 'H2269000', 'H2280600', 'H30-0400'];
            const annee1 = 2010;
            const annee2 = 2020;
            

            const moyennesParAnnee = {};
            for (const code of codeCoursEau) {
                
                const moyennes = await getEvolutionCoursEau(annee1, annee2, code);
                console.log(moyennes);
                for (const annee in moyennes) {
               
                    if (!moyennesParAnnee[annee]) {
                        moyennesParAnnee[annee] = [];
                    }
                    moyennesParAnnee[annee].push(moyennes[annee]);
                }
            }

            // Afficher les données dans le tableau
            const tableBody = document.getElementById('evolutionTable');
            for (const annee in moyennesParAnnee) {
                const moyenneAnnee = moyennesParAnnee[annee].reduce((acc, curr) => acc + curr, 0) / moyennesParAnnee[annee].length;
                const row = `<tr><td>${annee}</td><td>${moyenneAnnee}</td></tr>`;
                tableBody.innerHTML += row;
            }

            // Préparation des données pour Chart.js
            const labels = Object.keys(moyennesParAnnee);
            const data = labels.map(annee => moyennesParAnnee[annee].reduce((acc, curr) => acc + curr, 0) / moyennesParAnnee[annee].length);

            // Création du graphique
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Moyenne de température',
                        data: data,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

        afficherEvolution();
    </script>
</body>
</html>
