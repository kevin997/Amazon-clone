<?php

//use App\Http\Controllers\BecomeSellerController;
use App\Http\Controllers\CategorieProduitController;
//use App\Http\Controllers\DetailProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PlanVenteController;
use App\Http\Controllers\ProduitController;
//use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TvaController;
use App\Http\Controllers\UserController;
//use App\Http\Controllers\UserProfileController;
//use App\Models\UserProfile;
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
// test
Route::get('/test', function(){
    return ('test');
});

// inscription
Route::post('/register', [UserController::class, 'register']);

// connexion
Route::post('/login', [UserController::class, 'login']);

// get users
Route::get('/users', [UserController::class, 'index']);

// show user
Route::get('/view_user/{id}', [UserController::class, 'show']);

// edit user
Route::get('/edit_user/{id}', [UserController::class, 'edit']);

// delete user
Route::delete('/delete_user/{id}', [UserController::class, 'destroy']);

// update user
Route::patch('/update_user/{id}', [UserController::class, 'update']);

// Protection de certaines routes
Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);




//********************** ROUTES FOR ONLY AUTHENTIFY USERS ******************************************************* */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//*************************ROUTES FOR EVERYONE *********************** */


// inscription
//Route::post('register', [UserController::class, 'register']);



// afficher tout le catalogue des produits
Route::get('/catalogue/produit', [ProduitController::class, 'index']);

// voir description d'un produit
Route::get('/catalogue/produit/{id}', [ProduitController::class, 'show']);



//*************************ROUTES EXCLUSIVEMENT RESERVEES AUX UTILISATEURS AUTHENTIFIES *********************** */

Route::group(['middleware' => ['auth:sanctum']], function() {

    // deconnexion de l'utilisateur
    Route::post('/logout',   [UserController::class, 'logout']);

    // devenir un vendeur
    //Route::post('/become_seller', [BecomeSellerController::class, 'createStore']);

    // creer un profil
    //Route::post('/create_profil', [UserProfileController::class, 'store']);

    // afficher les infos du profil
    //Route::get('/profil', [UserProfileControalleerProfileController::class, 'update']);

    // detail du profil
    //Route::get('/edit_profil/{id}', [UserProfileController::class, 'edit']);

    // delete profil
    //Route::delete('/delete_profil/{id}', [UserProfileController::class, 'delete']);    

    // creer un taux de tva
    Route::post('/create_tva', [TvaController::class, 'store']);

    // afficher la grille des tva
    Route::get('/tva', [TvaController::class, 'index']);

    // editer un taux de tva
    Route::get('/edit_tva/{id}', [TvaController::class, 'edit']);

    // mise a jour du taux tva
    Route::patch('/update_tva/{id}', [TvaController::class, 'update']);

    // suppression du taux tva
    Route::delete('/delete_tva/{id}', [TvaController::class, 'destroy']);    

    // creer un store pour un vendeur
    Route::post('/create_store', [StoreController::class, 'create']);

    // afficher liste des stores pour un vendeur
    Route::get('/store/{id}', [StoreController::class, 'show']);

    // afficher liste des stores
    Route::get('/store', [StoreController::class, 'index']);

    // mise a jour du store (boutique)
    Route::patch('/update_store/{id}', [StoreController::class, 'update']);

    // fermeture du store (boutique) par son proprietaire
    Route::patch('/close_store/{id}', [StoreController::class, 'close']);    //status = "closed"

    // suppression du store (boutique) par l'administrateur
    Route::delete('/delete_store/{id}', [StoreController::class, 'delete']);     //status = "deleted"

    // editer la liste des stores pour vendeur
    Route::get('/edit_store/{id}', [StoreContralleeoller::class, 'edit']);

    // creer un plan de vente
    Route::post('/create_plan_vente', [PlanVenteController::class, 'store']);

    // afficher la liste des plans de vente
    Route::get('/plan_vente', [PlanVenteController::class, 'index']);

    // editer un plan de vente
    Route::get('/edit_plan_vente/{id}', [PlanVenteController::class, 'edit']);

    // mise a jour d'un plan de vente
    Route::patch('/update_plan_vente/{id}', [PlanVenteController::class, 'update']);

    // suppression d'un plan de vente
    Route::delete('/delete_plan_vente/{id}', [PlanVenteController::class, 'delete']);    

    // afficher un plan de vente
    Route::get('/plan_vente/{id}', [PlanVenteController::class, 'show']);

    // creer une categorie produit
    Route::post('/create_categorie_produit', [CategorieProduitController::class, 'store']);    

    // mise a jour d'une categorie produit
    Route::patch('/update_categorie_produit/{id}', [CategorieProduitController::class, 'update']);

    // afficher la liste des categories produit
    Route::get('/categorie_produit', [CategorieProduitController::class, 'index']);

    // editer une categorie produit
    Route::get('/edit_categorie_produit/{id}', [CategorieProduitController::class, 'edit']);

    // mise a jour d'une categorie produit
    Route::patch('/update_categorie_produit/{id}', [CategorieProduitController::class, 'update']);

    // suppression d'une categorie produit
    Route::delete('/delete_categorie_produit/{id}', [CategorieProduitController::class, 'delete']);

    // creer un produit au profit d'un store
    Route::post('/create_product', [ProduitController::class, 'store']);

    // afficher le catalogue de produits
    Route::get('/catalogue_product', [ProduitController::class, 'index']);

    // afficher un produits
    Route::get('/catalogue_product/{id}', [ProduitController::class, 'show']);

    // afficher le catalogue de produits par boutique
    Route::get('/catalogue_product_from_store/{id}', [ProduitController::class, 'showStoreProduct']);

    // editer un produit
    Route::get('/edit_product/{id}', [ProduitController::class, 'edit']);    

    // mise a jour d'un produit
    Route::patch('/update_product/{id}', [ProduitController::class, 'update']);

    // sortie d'un produit du catalogue
    Route::patch('/remove_produit/{id}', [ProduitController::class, 'remove']); // etat = "indisponible"

    // suppression du produit du catalogue par l'administrateur
    Route::patch('/delete_produit/{id}', [ProduitController::class, 'delete']);    // etat = "definitivement supprime"

    // mise a jour d'un stock
    //Route::patch('/update_stock/{id}', [StockalleeController::class, 'Update']);

    // creation du panier d'achats
    Route::post('/add_to_cart', [PanierController::class, 'AjouterLignePanier']);

    // retirer du panier d'achats
    Route::post('/remove_to_cart', [PanierController::class, 'SupprimerLignePanier']);

    // vider le panier d'achats
    Route::post('/empty_cart', [PanierController::class, 'ViderPanier']);

    // valider le panier d'achats
    Route::post('/validate_cart', [PanierController::class, 'ValiderPanier']);

    // afficher un panier d'achats
    Route::post('/orders/place_order/{id}', [PanierController::class, 'index']);
    

    //*************************EMAIL MANAGE ******************************************* */

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

    // obtenir les infos de l'utilisateur connecte
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', function () {
        // Only verified users may access this route...
    })->middleware(['auth', 'verified']);
  });


