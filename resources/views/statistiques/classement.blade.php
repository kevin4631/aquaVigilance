<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Classement des régions </title>
</head>
<body>
<?php

// Inclure le fichier getDelta.php
include 'getDelta.php';

$liste_code_cours_eau = [];
$liste_code_cours_eau = sql::select("SELECT code_cours_eau FROM cours_eau;");





?>
</body>
</html>