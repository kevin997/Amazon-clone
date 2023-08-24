<?php

use App\Http\Controllers\BecomeSellerController;
use App\Http\Controllers\CategorieProduitController;
use App\Http\Controllers\DetailProduitController;
use App\Http\Controllers\PlanVenteController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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


// s'inscrire
Route::post('register', [UserController::class, 'register']);

// se connecter
Route::post('login', [UserController::class, 'login'])->name('connexion');

//***********************TRAITEMENT DE L'EMAIL VERICIATION ****************** */
// notification de l'envoi de l'email de verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// verification proprement dite de l'email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// renvoie de l'email de verification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Protection de certaines routes
Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);

//***************************************************************************** */

// groupe de route dont l'acces n'est autorise qu'aux utilisateurs identifies
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

    // verification email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        
        // on recupere les infos de l'utilisateur connecte
        $user = Auth::user();
    
        return response()->json([
            'message' => 'Votre email vient d\'etre verifie.',
            'datas' => $user
        ]);
    })->middleware(['auth', 'signed'])->name('verification.verify');

    // resend email for verification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return response()->json([
            'message' => 'Un nouveau email de verification vous a ete envoye'
        ]);
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // devenir un vendeur 
    Route::post('/become_seller', [BecomeSellerController::class, 'createStore']);

    // creer un store pour un vendeur
    Route::post('/create_store', [StoreController::class, 'create']);

    // mise a jour du store (boutique)
    Route::patch('/update_store/{id}', [StoreController::class, 'update']);

    // fermeture du store (boutique) par son proprietaire
    Route::patch('/close_store/{id}', [StoreController::class, 'close']);

    // suppression du store (boutique) par l'administrateur
    Route::delete('/delete_store/{id}', [StoreController::class, 'delete']);

    // editer la liste des stores pour vendeur
    Route::get('/edit_store/{id}', [StoreController::class, 'edit']);

    // creer un plan de vente
    Route::post('/create_plan_vente', [PlanVenteController::class, 'store']);

    // mise a jour d'un plan de vente
    Route::patch('/update_plan_vente/{id}', [PlanVenteController::class, 'update']);

    // suppression d'un plan de vente
    Route::delete('/delete_plan_vente/{id}', [PlanVenteController::class, 'delete']);

    // editer la liste des plans de vente
    Route::get('/edit_plan_vente', [PlanVenteController::class, 'edit']);

    // afficher la liste des plans de vente
    Route::get('/show_plan_vente/{id}', [PlanVenteController::class, 'show']);

    // creer une categorie de produits
    Route::post('/create_categorie_produit', [CategorieProduitController::class, 'store']);

    // mise a jour d'une categorie
    Route::patch('/update_categorie_produit/{id}', [CategorieProduitController::class, 'update']);

    // afficher la liste des categories de produit
    Route::get('/show_categorie_produit/{id}', [CategorieProduitController::class, 'show']);

    // suppression d'une categorie de produit
    Route::delete('/delete_categorie_produit/{id}', [CategorieProduitController::class, 'delete']);

    // creer un produit au profit d'un store
    Route::post('/create_product', [ProduitController::class, 'store']);

    // mise a jour d'un produit
    Route::patch('/update_product/{id}', [ProduitController::class, 'update']);

    // sotie d'un produit du catalogue
    Route::patch('/remove_product/{id}', [ProduitController::class, 'remove']);

    // suppression du produit du catalogue par l'administrateur
    Route::delete('/delete_product/{id}', [ProduitController::class, 'delete']);

    // editer un produit
    Route::get('/edit_product/{id}', [ProduitController::class, 'edit']);

    // constituer un stock au profit d'un produit
    Route::post('/create_stock', [StockController::class, 'store']);

    // mise a jour d'un stock
    Route::patch('/update_stock/{id}', [StockController::class, 'update']);

    // ajouter une description a un produit
    Route::post('/create_detail_product', [DetailProduitController::class, 'store']);

    // mise a jour d'une description d'un produit
    Route::patch('/update_detail_product/{id}', [DetailProduitController::class, 'update']);

    // suppression de detail d'un produit
    Route::delete('/delete_product/{id}', [DetailProduitController::class, 'delete']);

    // obtenir les infos de l'utilisateur connecte
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', function () {
        // Only verified users may access this route...
    })->middleware(['auth', 'verified']);
  });


