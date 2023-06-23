<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// test
Route::get('/test', function(){
    return ('test');
});

// inscription
Route::post('register', [UserController::class, 'register']);

// connexion
Route::post('login', [UserController::class, 'login']);


// Groupe de routes protegees (uniquement pour les utilisateurs authentifies)
Route::group(['middleware' => ['auth:sanctum']], function() {

    // deconnexion de l'utilisateur  
    Route::post('logout',   [UserController::class, 'logout']);

    // enregistrer informations de profil
    Route::post('/create_profil', [UserProfileController::class, 'create']);

    // mise a jour du profil
    Route::patch('/update_profil/{id}', [UserProfileController::class, 'update']);

    // detail du profil
    Route::get('/edit_profil/{id}', [UserProfileController::class, 'edit']);

    // delete profil
    Route::delete('/delete_profil/{id}', [UserProfileController::class, 'delete']);

    // obtenir les infos de l'utilisateur connecte
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
  });


