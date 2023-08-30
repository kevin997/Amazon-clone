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

// afficher le catalogue de produit
Route::get('/catalogue/produit', [ProduitController::class, 'index']);

// editer un produit
Route::get('/edit_product/{id}', [ProduitController::class, 'edit']);

// voir details d'un produit
Route::get('/catalogue/produit/{id}', [ProduitController::class, 'show']);

// Groupe de routes protegees (uniquement pour les utilisateurs authentifies)
Route::group(['middleware' => ['auth:sanctum']], function() {

    // deconnexion de l'utilisateur  
    Route::post('logout',   [UserController::class, 'logout']);

    // mise a jour du profil
    Route::patch('/update_profil/{id}', [UserController::class, 'updateProfile']);

    // detail du profil
    Route::get('/edit_profil/{id}', [UserController::class, 'editProfile']);

    // delete profil
    Route::delete('/delete_profil/{id}', [UserController::class, 'deleteProfile']);

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

    // creer un taux de tva
    Route::post('/create_tva', [TvaController::class, 'store']);

    // mise a jour du taux tva
    Route::patch('/update_tva', [TvaController::class, 'update']);

    // suppression du taux tva
    Route::delete('/delete_tva/{id}', [TvaController::class, 'destroy']);

    // suppression du taux tva
    Route::get('/show_grille_tva', [TvaController::class, 'index']);

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

    // afficher le catalogue de produit
    Route::post('/catalogue/product_from_store/{id}', [ProduitController::class, 'showStoreProduct']);

    // creer un produit au profit d'un store
    Route::post('/create_product', [ProduitController::class, 'store']);

    // mise a jour d'un produit
    Route::patch('/update_product', [ProduitController::class, 'update']);

    // sotie d'un produit du catalogue
    Route::patch('/remove_produit/{id}', [ProduitController::class, 'remove']);

    // suppression du produit du catalogue par l'administrateur
    Route::delete('/delete_produit/{id}', [ProduitController::class, 'delete']);    

    // mise a jour d'un stock
    Route::patch('/update_stock', [StockController::class, 'UpdateStock']);

    // suppression de detail d'un produit
    Route::delete('/delete_product/{id}', [DetailProduitController::class, 'delete']);

    // creation du panier d'achat
    Route::post('/add_to_cart', [PanierController::class, 'AjouterLignePanier']);

    // retirer du panier d'achat
    Route::post('/remove_to_cart', [PanierController::class, 'SupprimerLignePanier']);

    // vider le panier d'achat
    Route::post('/empty_cart', [PanierController::class, 'ViderPanier']);

    // valider le panier d'achat
    Route::post('/validate_cart', [PanierController::class, 'ValiderPanier']);

    // valider le panier d'achat
    Route::post('/orders/place_order/{id}', [PanierController::class, 'index']);

    // obtenir les infos de l'utilisateur connecte
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', function () {
        // Only verified users may access this route...
    })->middleware(['auth', 'verified']);
  });


