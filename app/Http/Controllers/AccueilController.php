<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function accueil()
    {
        return view("accueil");
    }
    //TO DO

    public function classement() {

        // Tableau associatif des codes de région
$regions = [
    'guadeloupe' => 1,
    'ile_france' => 11,
    'martinique' => 2,
    'centre_val_loire' => 24,
    'bourgogne_franche_compte' => 27,
    'normandie' => 28,
    'guyane' => 3,
    'hauts_france' => 32,
    'reunion' => 4,
    'grand_est' => 44,
    'pays_loire' => 52,
    'bretagne' => 53,
    'mayotte' => 6,
    'nouvelle_aquitaine' => 75,
    'occitanie' => 76,
    'auvergne_rhone_alpes' => 84,
    'paca' => 93,
    'corse' => 94
];

// Tableau pour stocker les résultats
$cours_eau = [];

// Boucle pour récupérer les cours d'eau pour chaque région
foreach ($regions as $region => $code_region) {
    $cours_eau[$region] = DB::select("SELECT code_cours_eau 
                                       FROM association_region_eau
                                       WHERE code_region = $code_region;");
}




    return view("statistiques/classement", ['cours_eau' => $cours_eau]);
    }


}
