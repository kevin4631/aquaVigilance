<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des régions</title>
</head>
<body>
    <script src="js/evolution.js"></script>

    <!--------------- recupere tous les codes cours eau --------------->
    <script src="js/getAllCodeCoursEau.js"></script>
    
    <script>
        // Récupération des données PHP dans des variables JavaScript
        var coursEau = <?php echo json_encode($cours_eau); ?>;
        console.log(coursEau);

        // recup les codes cours eau
        var tab_codeCoursEau = getAllCodeCoursEau();

      // Initialisation d'un objet pour stocker les sommes des deltas par région
var sommes_deltas_par_region = {};

// Boucle à travers chaque région
for (var region in coursEau) {
    if (coursEau.hasOwnProperty(region)) {
        var sousTableau = coursEau[region];
        var ce_region = sousTableau.map(function(objet) {
            return objet.code_cours_eau; // Extraction de la valeur de la clé "code_cours_eau"
        });

        // Initialisation de la somme des deltas et du compteur de cours d'eau pour la région actuelle
        var somme_delta_region = 0;
        var nombre_cours_eau_region = 0;

        // Calcul de la somme des deltas pour la région actuelle
        getTabDelta(2010, 2020, ce_region).then(function(tab_delta) {
            for (var i = 0; i < tab_delta.length; i++) {
                if (tab_delta[i].delta != 999) {
                    somme_delta_region += parseInt(tab_delta[i].delta, 10);
                    nombre_cours_eau_region++; // Incrémentation du compteur de cours d'eau
                }
            }
            // Calcul de la moyenne des deltas pour la région et stockage dans l'objet
            sommes_deltas_par_region[region] = somme_delta_region / nombre_cours_eau_region;

            console.log("Moyenne des deltas pour la région : " + sommes_deltas_par_region[region]);
        }).catch(function(error) {
            console.error(error);
        });
    }
}


// Calcul de la moyenne des deltas pour chaque région
for (var region in sommes_deltas_par_region) {
    if (sommes_deltas_par_region.hasOwnProperty(region)) {
        var somme_delta_region = sommes_deltas_par_region[region];
        var nombre_cours_eau = coursEau[region].length;
        var moyenne_delta_region = somme_delta_region / nombre_cours_eau;
        console.log("Moyenne des deltas pour la région: " + moyenne_delta_region);
    }
}



    </script>
</body>
</html>
