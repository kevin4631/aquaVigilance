<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        // vérifie si l'utilisateur est deja connecté
        if (auth()->check()) {
            // redirigé vers temp
            return redirect()->route('temp');
        }

        // si il est pas connecté redirge page login
        return view('auth.login');
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
            return redirect()->route('temp');
        }

        // Redirection avec un message d'erreur si l'authentification échoue
        return redirect()->back()->withErrors('Les identifiants sont incorrects');
    }

    // Déconnexion
    public function logout()
    {
        auth()->logout();
        return redirect()->route('accueil');
    }

    public function creation()
    {
        return view('auth.creation');
    }

    // Enregistre un nouveau utilisateur
    public function store(Request $request)
    {
        // Valide les données du formulaire
        $form = $request->validate([
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
        return redirect()->route('temp');
    }
}
