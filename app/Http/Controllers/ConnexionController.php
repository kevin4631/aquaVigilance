<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ConnexionController extends Controller
{
    public function connexion()
    {
        // vérifie si l'utilisateur est deja connecté
        if (auth()->check()) {
            // redirigé vers temp
            return redirect()->route('accueil');
        }

        // si il est pas connecté redirge page login
        return view('connexion.connexion');
    }

    // Crée une session de connexion
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tente de s'authentifier avec les identifiants saissies, si ils sont bon redirge vers la page de saisie de température 
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('accueil');
        }

        // Redirection avec un message d'erreur si l'authentification échoue
        return redirect()->back()->withErrors('Les identifiants sont incorrects veuillez réssayer');
    }

    // Déconnexion
    public function deconnexion()
    {
        auth()->logout();
        return redirect()->route('accueil');
    }

    public function inscription_form()
    {
        return view('connexion.inscription_form');
    }

    // Enregistre un nouveau utilisateur
    public function inscription(Request $request)
    {
        // Valide les données du formulaire
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Crée un nouveau utilisateur avec le mot de passe crypté
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password) // crypté le mdp 
        ]);

        // Tente de s'authentifier avec les nouvelles informations
        $session = $request->only('email', 'password');
        Auth::attempt($session);

        // Régénère la session et redirige vers la page temp
        $request->session()->regenerate();
        return redirect()->route('accueil');
    }

    public function reinitialier_form()
    {
        return view('connexion.reinitialier_form');
    }

    public function reset(Request $request)
    {
        $request->input('email');
        $request->input('password');

        User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);
        return view ('connexion.connexion');
    }

    public function gestion_form(){
        return view('connexion.gestion_form');
    }

    public function gestion(Request $request)
    {
         // Valider le formulaire
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();

   
    if ($user) {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Account updated successfully!');
    } else {
        return redirect()->back()->withErrors('User not found.');
    }
}
}
