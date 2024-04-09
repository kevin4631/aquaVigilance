<?php

namespace App\Http\Controllers;

use App\Models\CoursEau;
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
        $cours_eaux = CoursEau::orderBy('libelle', 'asc')->get(['libelle']);
        return view('page.temperature.temp_form', ['cours_eaux' => $cours_eaux]);
    }
    public function saisir_temp(Request $request)
    {
        // récupérer l'id de l'utilisateur connecté
        $user_id = Auth::id();
        // crée une instance de ton model 
        $temperature = new Temperature();
        $temperature->longitude = $request->input('longitude');
        $temperature->latitude = $request->input('latitude');
        $temperature->libelle_commune = $request->input('libelle_commune');
        $temperature->libelle_cours_eau = $request->input('libelle_cours_eau');
        $date_mesure_temp = $request->input('date_mesure_temp') . ' ' . $request->input('heure_mesure_temp');
        $temperature->date_mesure_temp = $date_mesure_temp;
        $temperature->resultat = $request->input('resultat');
        //associer l'enregistrement avec l'id de l'utilisateur
        $temperature->id_saisir = $user_id;
        // enregistrer dans la bdd
        $temperature->save();

        return redirect()->route("accueil");
    }

    
    public function historique() {
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
