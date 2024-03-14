<?php

function getFileNameCoursEau()
{
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

    return $tabFileName;
}

function getDelta($annee1, $annee2)
{
    $total = 0;
    $nbData = 0;
    // variable qui ne change pas en fonction du cours d'eau

    $tabFileName = getFileNameCoursEau();

    $tab = array();

    foreach ($tabFileName  as $fileName) {
        // variable qui change en fonction du cours d'eau
        $code_cours_eau = substr($fileName, 0, -8);

        $json = json_decode(file_get_contents('../data/' . $code_cours_eau . '.json'), true);

        $nb_mesures_annee1 = 0;
        $nb_mesures_annee2 = 0;

        $total_annee1 = 0;
        $total_annee2 = 0;

        $tab1 = array();
        $tab2 = array();

        foreach ($json as $data) {
            if (substr($data["date_mesure_temp"], 0, -6) == $annee1) {
                $nb_mesures_annee1++;
                $total_annee1 += $data["resultat"];

                $tab1[] = $data["resultat"] . " " . $data["date_mesure_temp"];
            }

            if (substr($data["date_mesure_temp"], 0, -6) == $annee2) {
                $nb_mesures_annee2++;
                $total_annee2 += $data["resultat"];
                $tab2[] = $data["resultat"] . " " . $data["date_mesure_temp"];
            }
        }

        $calcul_imposible = 0;

        $moyenne_annee1 = 1;
        if ($nb_mesures_annee1 != 0) {
            $moyenne_annee1 = $total_annee1 / $nb_mesures_annee1;
        } else {
            $calcul_imposible = 1;
        }

        $moyenne_annee2 = 0;
        if ($nb_mesures_annee2 != 0) {
            $moyenne_annee2 = $total_annee2 / $nb_mesures_annee2;
        } else {
            $calcul_imposible = 1;
        }

        $delta = $moyenne_annee2 - $moyenne_annee1;

        if ($calcul_imposible == 0) {
            //echo $code_cours_eau . ' : ' . $annee2 . '-' . $annee1 . ' -> ' . $delta . "\n";
            $nbData++;
            $tab[$code_cours_eau] = $delta;
        } else {
            //echo $code_cours_eau . ' : ' . $annee2 . '-' . $annee1 . ' -> null' . "\n";
        }

        //var_dump($tab1);
        //var_dump($tab2);
        $total++;
    }
    //echo $annee1 . '-' . $annee2 . ' ' . $nbData . '/' . $total . "\n";
    //var_dump($tab);
    return $tab;
}

//echo '----- Debut du script -----' . "\n";

$tab = getDelta(2010, 2019);
$tab = json_encode($tab);
echo $tab;

//echo '----- Fin du script -----' . "\n";