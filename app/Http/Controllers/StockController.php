<?php

namespace App\Http\Controllers;

use App\Models\AmazonProduitStock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function store(Request $request){

        // on lance la validation des donnees
        $request->validate([
            "quantite_disponible" => "required|numeric|min:10",
            "saisi_par" => "required"
        ]);

        try {
            // qui est a l'origine de la saisie
            $user_name = Auth::user()->name;

            // traitement des donnees
            $stock = new AmazonProduitStock();
            $stock->produit_id = $request->produit_id;
            $stock->quantite_disponible = $request->quantite_disponible;
            $stock->saisi_par = $user_name;
            $stock->created_at = now();
            $stock->save();

            return response()->json([
                "status_code" => 1,
                "message" => "stock initial constitue avec succes.",
                "stock" => $stock
            ], 201);

            // redirection vers la saisie de la fiche descriptive du produit
            //........

        } catch (Exception $e) {
            return response()->json($e);
        }       
    }

    public function update(Request $request, $id){

        // on lance la validation des donnees
        $request->validate([
            "quantite_disponible" => "required|numeric|min:10",
            "saisi_par" => "required"
        ]);

        // qui est a l'origine de la saisie
        $user_name = Auth::user()->name;

        // on charge le stock du produit a mettre a jour
        $stock = AmazonProduitStock::where('produit_id', $id)->first();

        // on determine le nouveau stock
        $current_inventory = $stock->quantite_disponible + $request->quantite_disponible;

        try {
            // traitement des donnees
            $stock->update([
                'quantite_disponible' => $current_inventory,
                'saisi_par' => $user_name,                
                'updated_at' => now()
            ]);

            return response()->json([
                "status_code" => 1,
                "message" => "stock initial constitue avec succes.",
                "stock" => $stock
            ], 201);

            // redirection vers l'ecran de consultation des produits
            //........

        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
