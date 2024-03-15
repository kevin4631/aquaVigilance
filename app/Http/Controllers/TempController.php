<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur_T;
use Illuminate\Http\Request;

class TempController extends Controller
{
   
    public function temp(){ 
        return view("temp");
    // TDO TO
    }
    public function ajouterUtilisateur(Request $request)
{
    // Validation des données
    $validatedData = $request->validate([
        'longitude' => 'required',
        'latitude' => 'required',
        'libelle_commune' => 'required',
        'libelle_cours_eau' => 'required',
        'date_mesure_temp' => 'required',
        'heure_mesure_temp' => 'required',
        'resultat' => 'required',
    ]);

  
    $Utilisateur = new Utilisateur_T(); 
    $Utilisateur->longitude = $validatedData['longitude'];
    $Utilisateur->latitude = $validatedData['latitude'];
    $Utilisateur->libelle_commune = $validatedData['libelle_commune'];
    $Utilisateur->libelle_cours_eau = $validatedData['libelle_cours_eau'];
    $Utilisateur->date_mesure_temp = $validatedData['date_mesure_temp'];
    $Utilisateur->heure_mesure_temp = $validatedData['heure_mesure_temp'];
    $Utilisateur->resultat = $validatedData['resultat'];
    $Utilisateur->save();

    return redirect()->back()->with('success', 'Données enregistrées avec succès!');
}
}