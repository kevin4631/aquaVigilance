<?php

$repertoire = "tracesCoursEaux";

// Obtenez la liste des fichiers et dossiers dans le répertoire
$contenu = scandir($repertoire);

$tabNameFileTracesCoursEaux = array();

// Parcourez la liste
foreach ($contenu as $file) {
    // Excluez les entrées "." et ".."
    if ($file != "." && $file != "..") {
        $tabNameFileTracesCoursEaux[] = $file;
    }
}

// Encodez le tableau en JSON
$tabNameFileTracesCoursEaux = json_encode($tabNameFileTracesCoursEaux);

// Retournez le JSON
echo $tabNameFileTracesCoursEaux;
