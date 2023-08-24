<?php

namespace App\Http\Controllers;

use App\Models\AmazonCategorieProduit;
use App\Models\AmazonProduit;
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
        //
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
                "niveau_alerte" => "required|numeric",
                "seuil_recompletement" => "required|numeric"
            ]);

            try {
                //traitement des donnees
                $produit = new AmazonProduit();                
                $produit->categorie_produit_id = $request->categorie_produit_id;
                $produit->store_id = $request->store_id;
                $produit->designation = $request->designation;
                $produit->unite_emballage = $request->unite_emballage;
                $produit->devise = $request->devise;
                $produit->etat = "En attente";
                $produit->prix_unitaire = $request->prix_unitaire;
                $produit->prix_gros = $request->prix_gros;
                $produit->niveau_alerte = $request->niveau_alerte;
                $produit->seuil_recompletement = $request->seuil_recompletement;
                $produit->created_at = now();
                $produit->save();

                return response()->json([
                    "status_code" => 1,
                    "message" => "Ajout du produit ".$request->designation." reussie.",
                    "produit" => $produit
                ], 201);

                // redirection vers le formulaire de constitution de stock
                //........

            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                "status_code" => 0,
                "message" => "Vous devez detenir les habilitations de vendeur pour l'ajout de produits."
            ], 406);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // on recupere les informations relative au produit dont on a specifie l'id
        $produit = AmazonProduit::where('id', $id)->first();

        return view('produit', [
            'produit' => $produit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
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
    public function update(Request $request, $id)
    {
        // utilisateur logge ?
        $user_connected = Auth::user();

        // infos utilisateur pour retrouver son role
        $user_infos = User::where('id', $user_connected->id)->first();

        if($user_infos->hasRole(['Admin', 'Seller'])){    // Pour les detenteurs de compte amazon, il faut etre soit Admin, soit Seller
            // validation des donnees
            $request->validate([
                "designation" => "required",
                "unite_emballage" => "required",
                "prix_unitaire" => "required|numeric|between:0.000001, 999999999999",
                "niveau_alerte" => "required|numeric",
                "seuil_recompletement" => "required|numeric"
            ]);

            // on charge la categorie de produit a mettre a jour
            $produit = AmazonProduit::where('id', $id)->first();

            try {
                //traitement des donnees
                $produit->update([
                    'categorie_produit_id' => $request->categorie_produit_id,
                    'store_id' => $request->store_id,
                    'designation' => $request->designation,
                    'unite_emballage' => $request->unite_emballage,
                    'devise' => $request->devise,
                    'etat' => $request->etat,
                    'prix_unitaire' => $request->prix_unitaire,
                    'prix_gros' => $request->prix_gros,
                    'niveau_alerte' => $request->niveau_alerte,
                    'seuil_recompletement' => $request->seuil_recompletement,
                    'updated_at' => now()
                ]);

                return response()->json([
                    "status_code" => 1,
                    "message" => "Mise a jour de ". $request->designation ." reussie.",
                    "produit" => $produit
                ], 200);

                // redirection vers le formulaire de saisie
                //........

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
    public function destroy($id)
    {
        // on recupere le produit dont l'id a ete specifiee
        $produit = AmazonProduit::where('id', $id)->first();

        try {
            // on lance la procedure de suppression de produit
            $produit->delete();

            return response()->json([
                "status_code" => 1,
                "message" => "Suppression de ".$produit->name." reussie."
            ], 200);

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

            return response()->json([
                "status_code" => 1,
                "message" => "retrait du catalogue de ".$produit->designation." reussie.",
                "produit" => $produit
            ], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }   
    }
}
