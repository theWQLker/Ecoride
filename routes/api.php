<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPreferenceController;

//  Vérification API en fonctionnement / API Test Route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

//  Routes API pour la gestion des préférences utilisateur
// API Routes for managing user preferences
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/preferences', [UserPreferenceController::class, 'storeUserPreference']);
    Route::get('/user/preferences', [UserPreferenceController::class, 'getUserPreference']);
});
