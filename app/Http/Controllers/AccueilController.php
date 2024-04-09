<?php

namespace App\Http\Controllers;

use App\Models\Conseil;
use Illuminate\Http\Request;
use App\Models\Avis;

class AccueilController extends Controller
{
    public function accueil()
    {
        $conseils = Conseil::all()->groupBy('code_cours_eau');
        return view("accueil", ['conseils' => $conseils]);
    }

    public function evolution()
    {
        return view("statistiques/evolution");
    }

    public function laisser_avis(Request $request)
    {
        // Recherche ou crée un enregistrement avec l'id 0
        $avis = Avis::firstOrNew(['id' => 1]);

        // Met à jour les valeurs en fonction de la réponse
        $avis->oui = $avis->oui + ($request->input('reponse') == 'oui' ? 1 : 0);
        $avis->non = $avis->non + ($request->input('reponse') == 'non' ? 1 : 0);

        // Sauvegarde les changements
        $avis->save();

        return response()->json(['Votre avis a bien été enregistré.']);
    }
}
