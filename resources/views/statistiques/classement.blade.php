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

        // Supposons que coursEau[11] soit le sous-tableau dont vous voulez extraire les valeurs
        var sousTableau = coursEau[11];

        // Utilisation de la méthode map pour extraire les valeurs de chaque objet
        var ce_ileFrance = sousTableau.map(function(objet) {
            return objet.code_cours_eau; // Extraction de la valeur de la clé "code_cours_eau"
        });

        console.log(ce_ileFrance);

        var somme_delta_ile_france = 0;
        getTabDelta(2010, 2020, ce_ileFrance).then(function(tab_delta) {
                console.log(tab_delta[0]);
                for (var i = 0; i < tab_delta.length; i++) {
                    if (tab_delta[i].delta != 999) {
                        somme_delta_ile_france += parseInt(tab_delta[i].delta,10);
                    }
                }
                console.log(somme_delta_ile_france);
            }).catch(function(error) {
                console.error(error);
            });


    </script>
</body>
</html>
