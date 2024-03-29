<?php

namespace App\Http\Controllers;

use App\Models\Conseil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Temperature;

class SaisieTempController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function temp_formulaire()
    {
        return view("page/temperature.temp_form");
    }
    public function saisir_temp(Request $request)
    {
        // récupérer l'id de l'utilisateur connecté
        $user_id = Auth::id();
        // crée une instance de ton model 
        $temperature = new Temperature();

        $temperature->latitude = $request->input('latitude');
        $temperature->longitude = $request->input('longitude');
        $temperature->libelle_commune = $request->input('libelle_commune');
        $temperature->libelle_cours_eau = $request->input('libelle_cours_eau');
        $temperature->date_mesure_temp = $request->input('date_mesure_temp');
        $temperature->resultat = $request->input('resultat');
        //associer l'enregistrement avec l'id de l'utilisateur
        $temperature->id_saisir = $user_id;
        // enregistrer dans la bdd
        $temperature->save();


        return redirect()->route("accueil");
    }

    function historique() {
        $user_id = Auth::id();
        
        $temperatures = Temperature::where('id_saisir', $user_id)->get();
        
        return view('page.temperature.historique_temperature', ['temperatures' => $temperatures]);
    }

    public function supprimer($id)
    {
        $temperature = Temperature::findOrFail($id);

        $temperature->delete();

        return redirect()->route('historique');
    }
}
