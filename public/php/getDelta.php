<?php

function getDelta($annee1, $annee2, $code_cours_eau)
{
    $content = json_decode(file_get_contents('../data/' . $code_cours_eau . '.json'), true);

    $nb_mesures_annee1 = 0;
    $nb_mesures_annee2 = 0;

    $total_annee1 = 0;
    $total_annee2 = 0;

    //$tab1 = array();
    //$tab2 = array();

    foreach ($content as $data) {
        if (substr($data["date_mesure_temp"], 0, -6) == $annee1) {
            $nb_mesures_annee1++;
            $total_annee1 += $data["resultat"];
            //$tab1[] = $data["resultat"] . " " . $data["date_mesure_temp"];
        }

        if (substr($data["date_mesure_temp"], 0, -6) == $annee2) {
            $nb_mesures_annee2++;
            $total_annee2 += $data["resultat"];
            //$tab2[] = $data["resultat"] . " " . $data["date_mesure_temp"];
        }
    }

    $calcul_imposible = 0;

    $moyenne_annee1 = null;
    if ($nb_mesures_annee1 != 0) {
        $moyenne_annee1 = $total_annee1 / $nb_mesures_annee1;
    } else {
        $calcul_imposible = 1;
    }

    $moyenne_annee2 = null;
    if ($nb_mesures_annee2 != 0) {
        $moyenne_annee2 = $total_annee2 / $nb_mesures_annee2;
    } else {
        $calcul_imposible = 1;
    }

    if ($calcul_imposible == 1)
        return 999;

    return $moyenne_annee2 - $moyenne_annee1;
}

//echo '----- Debut du script -----' . "\n";

$annee1 = isset($_POST['annee1']) ? $_POST['annee1'] : null;
$annee2 = isset($_POST['annee2']) ? $_POST['annee2'] : null;
$code_cours_eau = isset($_POST['code_cours_eau']) ? $_POST['code_cours_eau'] : null;

if ($annee1 == null || $annee2 == null || $code_cours_eau == null) {
    echo "error";
} else {
    $delta = getDelta($annee1, $annee2, $code_cours_eau);
    echo json_encode($delta);
}

//echo '----- Fin du script -----' . "\n";