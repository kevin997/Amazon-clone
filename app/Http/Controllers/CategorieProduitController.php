<?php

namespace App\Http\Controllers;

use App\Models\AmazonCategorieProduit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategorieProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Afficher toutes les categories de produits
        $categorie_produits = AmazonCategorieProduit::all();

        return view('categorie_produits', [
            'liste_categories' => $categorie_produits
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // on affiche le formulaire de saisie
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

        if($user_infos->hasRole('Admin')){    // Pour les detenteurs de compte amazon
            // validation des donnees
            $request->validate([
                "name" => "required|unique:amazon_categorie_produits,name",
                "frais_vente_max" => "required|numeric"
            ]);

            try {
                //traitement des donnees
                $categorie_produit = new AmazonCategorieProduit();
                $categorie_produit->name = $request->name;
                $categorie_produit->details = $request->details;
                $categorie_produit->frais_vente_min = $request->frais_vente_min;
                $categorie_produit->frais_vente_max = $request->frais_vente_max;
                $categorie_produit->frais_cloture = $request->frais_cloture;
                $categorie_produit->frais_expedition = $request->frais_expedition;
                $categorie_produit->frais_stockage = $request->frais_stockage;
                $categorie_produit->frais_traitement_retour = $request->frais_traitement_retour;
                $categorie_produit->created_at = now();
                $categorie_produit->save();

                return response()->json([
                    "status_code" => 1,
                    "message" => "Ajout de la categorie ".$request->name." reussie.",
                    "categorie_produit" => $categorie_produit
                ], 201);

                // redirection vers le formulaire de saisie
                //........

            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                "status_code" => 0,
                "message" => "Vous devez detenir les habilitations d'administrateur pour ajouter une categorie de produits."
            ], 406);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // on recupere les informations relative a la categorie dont on a specifie l'id
        $categorie_produit = AmazonCategorieProduit::where('id', $id)->first();

        return view('categorie_produit', [
            'categorie' => $categorie_produit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

        if($user_infos->hasRole('Admin')){    // Pour les detenteurs de compte amazon
            // validation des donnees
            $request->validate([
                "name" => "required",
                "frais_vente_max" => "required|numeric"
            ]);

            // on charge la categorie de produit a mettre a jour
            $categorie_produit = AmazonCategorieProduit::where('id', $id)->first();

            try {
                //traitement des donnees
                $categorie_produit->update([
                    'name' => $request->name,
                    'details' => $request->details,
                    'frais_vente_min' => $request->frais_vente_min,
                    'frais_vente_max' => $request->frais_vente_max,
                    'frais_cloture' => $request->frais_cloture,
                    'frais_expedition' => $request->frais_expedition,
                    'frais_stockage' => $request->frais_stockage,
                    'frais_traitement_retour' => $request->frais_traitement_retour,
                    'updated_at' => now()
                ]);
                
                return response()->json([
                    "status_code" => 1,
                    "message" => "Mise a jour de la categorie ". $request->name ." reussie.",
                    "categorie_produit" => $categorie_produit
                ], 200);

                // redirection vers le formulaire de saisie
                //........

            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                "status_code" => 0,
                "message" => "Vous devez detenir les habilitations d'administrateur pour ajouter une categorie de produits."
            ], 406);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // on recupere la categorie dont l'id a ete specifiee
        $categorie_produit = AmazonCategorieProduit::where('id', $id)->first();

        try {
            // on lance la procedure de suppression du produit
            $categorie_produit->delete();

            return response()->json([
                "status_code" => 1,
                "message" => "Suppression de la categorie ".$categorie_produit->name." reussie."
            ], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
