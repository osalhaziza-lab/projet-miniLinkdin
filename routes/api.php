<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// Auth public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Routes protegees
Route::middleware('auth:api')->group(function () {

    // Auth
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me',       [AuthController::class, 'me']);

    // Profil
    Route::post('/profil', [ProfilController::class, 'store']);
    Route::get('/profil',  [ProfilController::class, 'show']);
    Route::put('/profil',  [ProfilController::class, 'update']);
    Route::delete('/profil/competences/{competence_id}', [ProfilController::class, 'removeCompetence']);

    // Offres
    Route::get('/offres',           [OffreController::class, 'index']);
    Route::get('/offres/{offre}',   [OffreController::class, 'show']);
    Route::post('/offres',          [OffreController::class, 'store']);
    Route::put('/offres/{offre}',   [OffreController::class, 'update']);
    Route::delete('/offres/{offre}',[OffreController::class, 'destroy']);

    // Candidatures
    Route::post('/offres/{offre}/postuler',          [CandidatureController::class, 'postuler']);
    Route::get('/mes-candidatures',                  [CandidatureController::class, 'mesCandidatures']);
    Route::get('/offres/{offre}/candidatures',       [CandidatureController::class, 'candidaturesOffre']);
    Route::put('/candidatures/{candidature}/statut', [CandidatureController::class, 'changerStatut']);

    // Admin
    Route::middleware('check.role:admin')->group(function () {
        Route::get('/admin/users',                 [AdminController::class, 'listeUsers']);
        Route::delete('/admin/users/{user}',       [AdminController::class, 'supprimerUser']);
        Route::put('/admin/offres/{offre}/toggle', [AdminController::class, 'toggleOffre']);
    });
});