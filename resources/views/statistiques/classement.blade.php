<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Classement des régions </title>
</head>
<body>
<?php




 
?>


<script src="js/evolution.js"></script>
<script src="js/getAllCodeCoursEau.js"></script>
    <script>
        var tab_codeCoursEau = getAllCodeCoursEau();
        getTabDelta(2010, 2020, tab_codeCoursEau).then(function(tab_delta) {
        console.log(tab_delta);
        }).catch(function(error) {
            console.error(error);
        
        });

        </script>
</body>
</html>