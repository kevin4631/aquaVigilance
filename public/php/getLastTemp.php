<?php

function getLastTemp($code_cours_eau)
{
    $content = json_decode(file_get_contents('../data/' . $code_cours_eau . '.json'), true);

    $lastData = end($content);
    $lastTemp = [
        "resultat" => $lastData["resultat"],
        "date_mesure_temp" => $lastData["date_mesure_temp"],
        "heure_mesure_temp" => $lastData["heure_mesure_temp"]
    ];

    return $lastTemp;
}


//echo '----- Debut du script -----' . "\n";

$code_cours_eau = isset($_POST['code_cours_eau']) ? $_POST['code_cours_eau'] : null;

if ($code_cours_eau == null) {
    echo "error";
} else {
    $lastTemp = getLastTemp($code_cours_eau);
    echo json_encode($lastTemp);
}

//echo '----- Fin du script -----' . "\n";