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

Route::get('login', [AuthController::class, 'login'])->name('connexion');
Route::post('creation', [AuthController::class, 'creation'])->name('inscription');
Route::post('store', [AuthController::class, 'store'])->name('store');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authentification');
Route::post('logout', [AuthController::class, 'logout'])->name('deconnexion');
Route::get('temp', [TempController::class, 'temp'])->name('temp')->middleware('auth');
