<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\SaisieTempController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AccueilController::class, 'accueil'])->name('accueil');


Route::middleware('auth')->group(function () {
    // routes accessible uniquement quand l'utilisateur est connecté
    Route::get('temp_formulaire', [SaisieTempController::class, 'temp_formulaire'])->name('temp_formulaire');
    Route::post('saisir_temp', [SaisieTempController::class, 'saisir_temp'])->name('saisir_temp');
    Route::get('historique', [SaisieTempController::class, 'historique'])->name('historique');
    Route::get('temperature/{id}/supprimer', [SaisieTempController::class, 'supprimer'])->name('temperature.supprimer');
    Route::get('deconnexion', [ConnexionController::class, 'deconnexion'])->name('deconnexion');
    Route::get('gestion_form', [ConnexionController::class, 'gestion_form'])->name('gestion_form');
    Route::post('gestion', [ConnexionController::class, 'gestion'])->name('gestion');
});

Route::middleware('guest')->group(function () {
    // routes accessible en tant qu'observateur
    Route::get('connexion', [ConnexionController::class, 'connexion'])->name('connexion');
    Route::post('inscription_form', [ConnexionController::class, 'inscription_form'])->name('inscription_form');
    Route::post('inscription', [ConnexionController::class, 'inscription'])->name('inscription');
    Route::post('reinitialier_form', [ConnexionController::class, 'reinitialier_form'])->name('reinitialier_form');
    Route::post('reset', [ConnexionController::class, 'reset'])->name('reset');
    Route::post('authenticate', [ConnexionController::class, 'authenticate'])->name('authentification');
});

Route::post('laisser_avis', [AccueilController::class, 'laisser_avis'])->name('laisser_avis');
Route::get('evolution', [AccueilController::class, 'evolution'])->name('evolution');