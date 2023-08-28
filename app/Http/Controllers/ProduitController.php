<?php

namespace App\Http\Controllers;

use App\Models\AmazonProduit;
use App\Models\AmazonProduitDetail;
use App\Models\AmazonProduitStock;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // on affiche les produits du catalogue dont le stock est superieur au seuil de recompletement
        $produits = AmazonProduit::orderBy('designation')->get();

        return response()->json([
            "status_code" => 1,
            "produit" => $produits
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // afficher le formulaire d'ajout de produits
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // utilisateur logge ?
        $user_connected = Auth::user();

        // infos utilisateur pour retrouver son role
        $user_infos = User::where('id', $user_connected->id)->first();

        if($user_infos->hasRole(['Admin', 'Seller'])){    // Pour les detenteurs de compte amazon, il faut etre soit Admin 
            // validation des donnees
            $request->validate([
                "designation" => "required|unique:amazon_produits,designation",
                "unite_emballage" => "required",
                "prix_unitaire" => "required|numeric|between:0.000001, 999999999999",
                "quantite_disponible" => "required|numeric|min:10",
                "niveau_alerte" => "required|numeric",
                "seuil_recompletement" => "required|numeric",
                "description" => "required",
                "photo_1" => "required|url"
            ]);

            try {
                //traitement des donnees
                //-------------- 1- ENREGISTREMENT D'UN PRODUIT -----------------
                $produit_new = new AmazonProduit();

                $produit_new->categorie_produit_id = $request->categorie_produit_id;
                $produit_new->store_id = $request->store_id;
                $produit_new->designation = $request->designation;
                $produit_new->unite_emballage = $request->unite_emballage;
                $produit_new->devise = $request->devise;
                $produit_new->etat = "Disponible";
                $produit_new->prix_unitaire = $request->prix_unitaire;
                $produit_new->prix_gros = $request->prix_gros;
                $produit_new->niveau_alerte = $request->niveau_alerte;
                $produit_new->seuil_recompletement = $request->seuil_recompletement;
                $produit_new->created_at = now();
                $produit_new->save();

                // on charge les infos du nouveau produit
                $produit = AmazonProduit::find($produit_new->id);
                

                //-------------- 2- AJOUT DETAILS DU PRODUIT -----------------
                $detail = new AmazonProduitDetail();                
                $detail->description = $request->description;
                $detail->photo_1 = $request->photo_1;
                $detail->photo_2 = $request->photo_2;
                $detail->photo_3 = $request->photo_3;
                $detail->photo_4 = $request->photo_4;
                $detail->photo_5 = $request->photo_5;
                $detail->video_explained = $request->video_explained;
                $detail->created_at = now();                
                $produit->detail()->save($detail);                
                
                //-------------- 3- CONSTITUTION DU STOCK INITIAL DU PRODUIT -----------------
                $stock = new AmazonProduitStock();
                $stock->quantite_disponible = $request->quantite_disponible;
                $stock->saisi_par = $user_infos->name;
                $stock->created_at = now();                
                $produit->stock()->save($stock);
               
                // redirection vers le formulaire de creation de produit
                return redirect('/catalogue/create_product');

            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return redirect('/home')->with(['message' => 'Seuls les vendeurs ont access a cette ressource.'], 406);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        // on recupere les informations relative au produit dont on a specifie l'id
        $produit = AmazonProduit::where('id', $id)->first();

        return view('produit', [
            'produit' => $produit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        // on recupere les informations du produit dont l'id a ete specifie
        $produit = AmazonProduit::where('id', $id)->first();

        return response()->json([
            "status_code" => 1,
            "message" => "Details du ". $produit->designation,
            "produit" => $produit
        ]);

        // redirection vers l'ecran d'affichage
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request){
        // utilisateur logge ?
        $user_connected = Auth::user();

        // infos utilisateur pour retrouver son role
        $user_infos = User::where('id', $user_connected->id)->first();

        if($user_infos->hasRole(['Admin', 'Seller'])){    // Pour les detenteurs de compte amazon, il faut etre soit Admin, soit Vendeur
            
            // validation des donnees
            $request->validate([
                "designation" => "required",
                "unite_emballage" => "required",
                "prix_unitaire" => "required|numeric|between:0.000001, 999999999999",
                "niveau_alerte" => "required|numeric",
                "seuil_recompletement" => "required|numeric",
                "description" => "required",
                "photo_1" => "required|url"
            ]);

            // on charge les infos du produit a mettre a jour
            $produit = AmazonProduit::find($request->produit_id);

            $etat = !isset($request->etat)? "En attente" : $request->etat;

            try {
                //traitement des donnees
                //-------------- 1- MISE A JOUR DU PRODUIT -----------------
                $produit->update([
                    'categorie_produit_id' => $request->categorie_produit_id,
                    'store_id' => $request->store_id,
                    'designation' => $request->designation,
                    'unite_emballage' => $request->unite_emballage,
                    'devise' => $request->devise,
                    'etat' => $etat,
                    'prix_unitaire' => $request->prix_unitaire,
                    'prix_gros' => $request->prix_gros,
                    'niveau_alerte' => $request->niveau_alerte,
                    'seuil_recompletement' => $request->seuil_recompletement,
                    'updated_at' => now()
                ]);

                //-------------- 2- MISE A JOUR DES DETAILS DU PRODUIT -----------------                
                $produit->detail()->update([
                    'description' => $request->description,
                    'photo_1' => $request->photo_1,
                    'photo_2' => $request->photo_2,
                    'photo_3' => $request->photo_3,
                    'photo_4' => $request->photo_4,
                    'photo_5' => $request->photo_5,
                    'video_explained' => $request->video_explained,
                    'updated_at' => $request->updated_at
                ]);

                // redirection vers le formulaire de saisie
                return redirect('/catalogue/product_from_store/{'.$produit->store_id.'}');

            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                "status_code" => 0,
                "message" => "Cette action est reservee aux vendeurs."
            ], 406);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        // on recupere le produit dont l'id a ete specifiee
        $produit = AmazonProduit::where('id', $id)->first();

        try {
            // on lance la procedure de suppression
            $produit->delete();

            return redirect('/catalogue/product_from_store/{'.$produit->store_id.'}')->with(['message' => 'Suppression de produit reussie.'], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function remove($id){

        // on recupere le produit a sortir du catalogue
        $produit = AmazonProduit::where('id', $id)->first();

        try {
            // on desactive le store (etat='desactive')
            $produit->update([
                'etat' => 'Retire des stocks', 
                'updated_at' => now()
            ]);

            return redirect('/catalogue/product_from_store{'.$produit->store_id.'}')->with(['message' => 'Sortie de stock du produit reussie.'], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }   
    }

    public function UpdateStock(Request $request){

        // Qui est a l'origine de cette action ?
        $user = Auth::user();

        // de quel produit s'agit t-il ?
        $produit = AmazonProduit::where('id', $request->produit_id)->first();

        $produit->stock()->update([
            'quantite_disponible' => $request->quantite,
            'saisi_par' => $user->name,
            'updated_at' => now()
        ]);

        return redirect('/catalogue/product_from_store/{'.$produit->id.'}')->with(['message' => 'Mise a jour du stock reussie.'], 200);
    }
}
