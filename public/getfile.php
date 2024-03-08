<?php
$repertoire = "traceCoursEau";

// Obtenez la liste des fichiers et dossiers dans le répertoire
$contenu = scandir($repertoire);

$monTableauPHP = array();

// Parcourez la liste
foreach ($contenu as $element) {
    // Excluez les entrées "." et ".."
    if ($element != "." && $element != "..") {
        $monTableauPHP[] = $element;
    }
}

// Encodez le tableau en JSON
$monTableauJSON = json_encode($monTableauPHP);

// Retournez le JSON
echo $monTableauJSON;
