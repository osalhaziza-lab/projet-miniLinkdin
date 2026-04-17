<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\ProfilController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me',       [AuthController::class, 'me']);

  Route::post('/profil', [ProfilController::class, 'store']);
    Route::get('/profil', [ProfilController::class, 'show']);
    Route::put('/profil', [ProfilController::class, 'update']);
    Route::post('/profil/competences', [ProfilController::class, 'addCompetence']);
    Route::delete('/profil/competences/{competence_id}', [ProfilController::class, 'removeCompetence']);

    Route::get('/offres', [OffreController::class, 'index']);
Route::get('/offres/{offre}', [OffreController::class, 'show']);
Route::post('/offres', [OffreController::class, 'store']);
Route::put('/offres/{offre}', [OffreController::class, 'update']);
Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);
});