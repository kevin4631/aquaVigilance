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

        th,
        td {
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

    <!-- Partie pour le graphique -->
    <h2>Graphique de l'évolution des températures par année</h2>
    <canvas id="myChart" width="800" height="400"></canvas>

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

    <script>
       async function getEvolutionCoursEauParRegion(annee1, annee2, codeRegion) {
    var tempAnnee = [];
    var anneeTraitement = annee1;
    var total = 0;
    var nbValeurs = 0;

    try {
        // Charger le fichier JSON contenant les codes de cours d'eau par région
        const response = await fetch("data/csvjson.json");
        const data = await response.json();

        // Récupérer les codes de cours d'eau pour la région spécifiée
        const coursEau = data[codeRegion];

        if (!coursEau) {
            console.log("Aucun cours d'eau trouvé pour le code de région " + codeRegion + ".");
            return tempAnnee;
        }

        // Pour chaque code de cours d'eau de la région spécifiée
        for (const codeCoursEau of coursEau) {
            // Charger le fichier JSON du cours d'eau
            const responseCoursEau = await fetch("data/" + codeCoursEau + ".json");
            const fileContent = await responseCoursEau.json();
            
            // Parcourir les données du fichier JSON
            fileContent.forEach(data => {
                var annee = parseInt(data["date_mesure_temp"].substring(0, 4));
                var temp = data["resultat"];
                // Vérifier si l'année est dans la plage spécifiée
                if (annee >= annee1 && annee <= annee2) {
                    // Si l'année change, calculer la moyenne et réinitialiser les valeurs
                    if (annee > anneeTraitement) {
                        var moyenne = total / nbValeurs;
                        tempAnnee.push({ moyenne, anneeTraitement });
                        total = 0;
                        nbValeurs = 0;
                        anneeTraitement = annee;
                    }
                    // Ajouter la température à la somme et incrémenter le nombre de valeurs
                    total += temp;
                    nbValeurs++;
                }
            });
        }
    } catch (error) {
        console.error("Erreur lors du chargement du fichier JSON :", error);
    }

    // Retourner les moyennes de température par année
    return tempAnnee;
}



        async function afficherEvolutionPourRegion() {
            const codeRegion = prompt("Veuillez entrer le code de région :");
            

            const annee1 = 2010;
            const annee2 = 2020;

            const moyennesParAnnee = await getEvolutionCoursEauParRegion(annee1, annee2, codeRegion);

            // Afficher les données dans le tableau
            const tableBody = document.getElementById('evolutionTable');
            moyennesParAnnee.forEach(annee => {
                const { moyenne, anneeTraitement } = annee;
                const row = `<tr><td>${anneeTraitement}</td><td>${moyenne}</td></tr>`;
                tableBody.innerHTML += row;
            });

            // Préparation des données pour Chart.js
            const labels = moyennesParAnnee.map(annee => annee.anneeTraitement);
            const data = moyennesParAnnee.map(annee => annee.moyenne);

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

        afficherEvolutionPourRegion();

    </script>
</body>

</html>
