<?php

use App\Http\Controllers\BecomeSellerController;
use App\Http\Controllers\CategorieProduitController;
use App\Http\Controllers\DetailProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PlanVenteController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TvaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
Route::post('register', [UserController::class, 'register']);

// se connecter
Route::post('login', [UserController::class, 'login']);

// groupe de routes dont l'acces n'est autorise qu'aux utilisateurs identifies
Route::group(['middleware' => ['auth::sanctum']], function(){

    // se deconnecter
    Route::get('logout', [UserController::class, 'logout']);

    // devenir vendeur
    Route::post('becomeSeller', [UserController::class, 'becomeSeller'])->name('devenirVendeur');

    // mettre a jour les informations du profil
    Route::post('updateProfile', [UserController::class, 'UpdateProfile'])->name('majProfil');    

    // afficher les details du profil utilisateur
    Route::get('getProfile',[UserController::class, 'getDetailProfile'])->name('afficheDetailsProfil');
});