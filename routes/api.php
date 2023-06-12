<?php

use App\Http\Controllers\UserController;
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

// s'inscrire
Route::post('register', [UserController::class, 'register'])->name('creerCompte');

// se connecter
Route::post('login', [UserController::class, 'login'])->name('connexion');

Route::group(['middleware' => ['auth::sanctum']], function(){

    // devenir vendeur
    Route::post('becomeSeller', [UserController::class, 'becomeSeller'])->name('devenirVendeur');

    // mettre a jour les informations du profil
    Route::post('updateProfile', [UserController::class, 'UpdateProfile'])->name('majProfil');

    // se deconnecter
    Route::get('logout', [UserController::class, 'logout'])->name('deconnexion');

    // afficher les details du profil utilisateur
    Route::get('getProfile',[UserController::class, 'getDetailProfile'])->name('afficheDetailsProfil');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
