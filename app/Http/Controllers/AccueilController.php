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
        $avis = new Avis();
        $avis->oui = $request->input('reponse') == 'oui' ? 1 : 0; 
        $avis->non = $request->input('reponse') == 'non' ? 1 : 0; 
        $avis->save();
        
        return response()->json(['Votre avis a bien été enregistré.']);
    }
}
