<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\TempController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('connexion', [AuthController::class, 'connexion'])->name('connexion');
Route::post('inscription_form', [AuthController::class, 'inscription_form'])->name('inscription_form');
Route::post('inscription', [AuthController::class, 'inscription'])->name('inscription');
Route::post('reinitialier_form', [AuthController::class, 'reinitialier_form'])->name('reinitialier_form');
Route::post('reset', [AuthController::class, 'reset'])->name('reset');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authentification');
Route::post('deconnexion', [AuthController::class, 'deconnexion'])->name('deconnexion');
Route::get('temp', [TempController::class, 'temp'])->name('temp')->middleware('auth');
