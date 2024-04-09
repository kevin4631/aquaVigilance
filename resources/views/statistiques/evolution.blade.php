<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evolution des températures des cours d'eau</title>
    <link rel="stylesheet" href="css/header.css" />

    <script src="https://d3js.org/d3.v7.min.js"></script>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 100px;
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

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            background-color: #333; /* Couleur de fond */
            padding: 10px 0; /* Ajout de padding en haut et en bas */
        }

        li {
            margin: 0 10px; /* Marge entre les éléments */
        }

        li a {
            text-decoration: none;
            color: #fff; /* Couleur du texte */
            font-weight: bold;
            padding: 5px 10px; /* Padding à l'intérieur des liens */
            border-radius: 5px; /* Coins arrondis */
            transition: background-color 0.3s ease; /* Transition fluide */
        }

        li a:hover {
            background-color: #555; /* Couleur de fond au survol */
        }

    </style>
</head>
<body>
@include('headfoot/header')
    <!-- Liste des régions -->
    <ul id="regionsList">
        <li><a href="#" data-code="11">Île-de-France</a></li>
        <li><a href="#" data-code="24">Centre-Val de Loire</a></li>
        <li><a href="#" data-code="27">Bourgogne-Franche-Comté</a></li>
        <li><a href="#" data-code="28">Normandie</a></li>
        <li><a href="#" data-code="32">Hauts-de-France</a></li>
        <li><a href="#" data-code="44">Grand Est</a></li>
        <li><a href="#" data-code="52">Pays de la Loire</a></li>
        <li><a href="#" data-code="53">Bretagne</a></li>
        <li><a href="#" data-code="75">Nouvelle-Aquitaine</a></li>
        <li><a href="#" data-code="76">Occitanie</a></li>
        <li><a href="#" data-code="84">Auvergne-Rhône-Alpes</a></li>
        <li><a href="#" data-code="93">Provence-Alpes-Côte d'Azur</a></li>
        <li><a href="#" data-code="94">Corse</a></li>
    </ul>

    <!-- Partie pour le graphique -->
    <h1>Evolution des températures des cours d'eau</h1>
    <svg id="temperatureChart" width="800" height="400"></svg>

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
    @include('headfoot/footer')

    <script>
        // Fonction pour afficher l'évolution des températures pour une région donnée
        async function afficherEvolutionPourRegion(codeRegion) {
            const annee1 = 2010;
            const annee2 = 2020;
            const moyennesParAnnee = {};

            try {
                const response = await fetch("data/csvjson.json");
                const data = await response.json();
                const coursEau = data[codeRegion];

                if (!coursEau) {
                    console.log("Aucun cours d'eau trouvé pour le code de région " + codeRegion + ".");
                    return;
                }

                for (const codeCoursEau of coursEau) {
                    const responseCoursEau = await fetch("data/" + codeCoursEau + ".json");
                    const fileContent = await responseCoursEau.json();

                    fileContent.forEach(data => {
                        var annee = parseInt(data["date_mesure_temp"].substring(0, 4));
                        var temp = data["resultat"];
                        if (annee >= annee1 && annee <= annee2 + 1) {
                            if (!moyennesParAnnee[annee]) {
                                moyennesParAnnee[annee] = [];
                            }
                            moyennesParAnnee[annee].push(temp);
                        }
                    });
                }
            } catch (error) {
                console.error("Erreur lors du chargement du fichier JSON :", error);
            }

            // Afficher les données dans le tableau
            const tableBody = document.getElementById('evolutionTable');
            tableBody.innerHTML = ''; // Réinitialiser le contenu
            for (const annee in moyennesParAnnee) {
                const moyenneAnnee = moyennesParAnnee[annee].reduce((acc, curr) => acc + curr, 0) / moyennesParAnnee[annee].length;
                const row = `<tr><td>${annee}</td><td>${moyenneAnnee.toFixed(2)} °C</td></tr>`;
                tableBody.innerHTML += row;
            }

            // Dessiner le graphique
            dessinerGraphique(moyennesParAnnee);
        }

        // Fonction pour dessiner le graphique
        function dessinerGraphique(moyennesParAnnee) {
            const labels = Object.keys(moyennesParAnnee);
            const data = Object.values(moyennesParAnnee).map(moyennes => moyennes.reduce((acc, curr) => acc + curr, 0) / moyennes.length);

            // Supprimer le graphique existant s'il y en a un
            d3.select("#temperatureChart").selectAll("*").remove();

            // Configuration du graphique à lignes avec D3.js
            const margin = { top: 20, right: 30, bottom: 30, left: 60 };
            const width = 1600 - margin.left - margin.right;
            const height = 600 - margin.top - margin.bottom;

            const svg = d3.select("#temperatureChart")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", `translate(${margin.left},${margin.top})`);

            const x = d3.scaleLinear()
                .domain([d3.min(labels), d3.max(labels)])
                .range([0, width]);

            const y = d3.scaleLinear()
                .domain([0, d3.max(data)])
                .range([height, 0]);

            const line = d3.line()
                .x((d, i) => x(labels[i]))
                .y(d => y(d))
                .curve(d3.curveMonotoneX);

            svg.append("path")
                .datum(data)
                .attr("fill", "none")
                .attr("stroke", "steelblue")
                .attr("stroke-width", 1.5)
                .attr("d", line);

            svg.append("g")
                .attr("transform", `translate(0,${height})`)
                .call(d3.axisBottom(x));

            svg.append("g")
                .call(d3.axisLeft(y));

            svg.append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 0 - margin.left)
                .attr("x", 0 - (height / 2))
                .attr("dy", "1em")
                .style("text-anchor", "middle")
                .text("Température (°C)");

            svg.append("text")
                .attr("transform", `translate(${width / 2}, ${height + margin.top + 20})`)
                .style("text-anchor", "middle")
                .text("Année");
        }

        // Écouter les clics sur les éléments de la liste des régions
        const regionsList = document.getElementById('regionsList');
        regionsList.addEventListener('click', function (event) {
            if (event.target.tagName === 'A') {
                const codeRegion = event.target.getAttribute('data-code');
                afficherEvolutionPourRegion(codeRegion);
            }
        });

        // Par défaut, afficher l'évolution pour la première région de la liste
        afficherEvolutionPourRegion('11');
    </script>
</body>
</html>
