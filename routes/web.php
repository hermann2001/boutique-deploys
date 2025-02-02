<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoutiqueController;
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

// Routes d'affichage des vues d'authentification (Inscription, Connexion, Mot de passe oublié et Réinitialisation de mot de passe)
Route::get('/signup', [AuthController::class, 'viewSignup'])->name('signup');
Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'viewForgotPassword'])->name('forgotpass');
Route::get('/reset-password', [AuthController::class, 'viewResetPassword'])->name('resetpass');

// Routes d'authentification (Inscription, Connexion, Mot de passe oublié, Réinitialisation de mot de passe et déconnexion)
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotpass');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetpass');

// Routes concernant les boutiques
Route::get('/create-boutique', [BoutiqueController::class, 'viewCreateBoutique'])->name('createBtq');
Route::post('/create-boutique', [BoutiqueController::class, 'createBoutique'])->name('createBtq');

Route::domain('{shop}.domain.xxx')->group(function () {
    Route::get('/', [BoutiqueController::class, 'viewBoutique']);
});
