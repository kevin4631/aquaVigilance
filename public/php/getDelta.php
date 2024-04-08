<?php

function getDelta($annee1, $annee2, $code_cours_eau)
{
    $content = json_decode(file_get_contents('../data/' . $code_cours_eau . '.json'), true);

    $delta = 0;

    $tabMesuresAnnee1 = array();
    $tabMesuresAnnee2 = array();

    $tabMoyenne = array();

    // ajout des valeurs dans des tableau pour les trier ensuite
    foreach ($content as $data) {
        if (substr($data["date_mesure_temp"], 0, -6) == $annee1) {
            $tabMesuresAnnee1[] = [
                "resultat" => $data["resultat"],
                "mois" => intval(explode("-", $data["date_mesure_temp"])[1])
            ];
        }

        if (substr($data["date_mesure_temp"], 0, -6) == $annee2) {
            $tabMesuresAnnee2[] = [
                "resultat" => $data["resultat"],
                "mois" => intval(explode("-", $data["date_mesure_temp"])[1])
            ];
        }
    }

    $lenghtMin = min(sizeof($tabMesuresAnnee1), sizeof($tabMesuresAnnee2));
    $iTab1 = 0;
    $iTab2 = 0;

    // boucle pour récuperer les valeurs uniquement des même mois pour avoir des valeurs cohérente
    while ($iTab1 < $lenghtMin - 1 && $iTab2 < $lenghtMin - 1) {
        if ($tabMesuresAnnee1[$iTab1]["mois"] == $tabMesuresAnnee2[$iTab2]["mois"]) {
            $tabMoyenne[] = ($tabMesuresAnnee2[$iTab2]["resultat"] - $tabMesuresAnnee1[$iTab1]["resultat"]);
            $iTab1++;
            $iTab2++;
        }

        if ($tabMesuresAnnee1[$iTab1]["mois"] < $tabMesuresAnnee2[$iTab2]["mois"]) {
            $iTab1++;
        }

        if ($tabMesuresAnnee1[$iTab1]["mois"] > $tabMesuresAnnee2[$iTab2]["mois"]) {
            $iTab2++;
        }
    }

    foreach ($tabMoyenne as $key => $value) {
        $delta += $value;
    }

    $nbValeurs = sizeof($tabMoyenne);

    if ($nbValeurs == 0)
        return 999;

    return $delta /= $nbValeurs;
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