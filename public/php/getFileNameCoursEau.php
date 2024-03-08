<?php
$repertoire = "../traceCoursEau";

// Obtenez la liste des fichiers et dossiers dans le répertoire
$contenu = scandir($repertoire);

$tabFileName = array();

// Parcourez la liste
foreach ($contenu as $fileName) {
    // Excluez les entrées "." et ".."
    if ($fileName != "." && $fileName != "..") {
        $tabFileName[] = $fileName;
    }
}

// Encodez le tableau en JSON
$tabFileName = json_encode($tabFileName);

// Retournez le JSON
echo $tabFileName;
