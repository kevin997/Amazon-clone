<?php

namespace App\Http\Controllers;

use App\Models\AmazonProduit;
use App\Models\AmazonProduitDetail;
use Exception;
use Illuminate\Http\Request;

class DetailProduitController extends Controller
{
    // saisie de la description detaillee d'un produit
    public function store(Request $request){
        
        // validation des donnees
        $request->validate([
            "description" => "required",
            "photo_1" => "required|url"
        ]);

        try {
            //traitement des donnees
            $detail = new AmazonProduitDetail();                
            $detail->produit_id = $request->produit_id;
            $detail->description = $request->description;
            $detail->photo_1 = $request->photo_1;
            $detail->photo_2 = $request->photo_2;
            $detail->photo_3 = $request->photo_3;
            $detail->photo_4 = $request->photo_4;
            $detail->photo_5 = $request->photo_5;
            $detail->video_explained = $request->video_explained;            
            $detail->created_at = now();
            $detail->save();

            return response()->json([
                "status_code" => 1,
                "message" => "Ajout fiche descriptive du produit n°".$detail->produit_id." reussie.",
                "detail" => $detail
            ], 201);

            // redirection vers le formulaire de saisie des produits
            //........

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id){
        
        // on charge les infos du produit dont l'id est passe en parametre
        $produit = AmazonProduit::where('id', $id)->first();

        // on recupere les details y afferents
        $details = AmazonProduitDetail::where('produit_id', $id)->first();

        // validation des donnees
        $request->validate([
            "description" => "required",
            "photo_1" => "required|url"
        ]);

        try {
            //traitement des donnees
            $details->update([
                'produit_id' => $request->produit_id,
                'description' => $request->description,
                'photo_1' => $request->photo_1,
                'photo_2' => $request->photo_2,
                'photo_3' => $request->photo_3,
                'photo_4' => $request->photo_4,
                'photo_5' => $request->photo_5,
                'video_explained' => $request->video_explained,
                'updated_at' => now()
            ]);

            return response()->json([
                "status_code" => 1,
                "message" => "Mise a jour de la fiche descriptive de ". $produit->designation ." reussie.",
                "produit" => $details
            ], 200);

            // redirection vers liste des produits
            //........

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id){
        // on recupere les details de produit dont l'id a ete specifie
        $detail = AmazonProduitDetail::where('id', $id)->first();

        try {
            // on lance la procedure de suppression des details du produit
            $detail->delete();

            return response()->json([
                "status_code" => 1,
                "message" => "Suppression details produit reussie."
            ], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id){
        // on recupere les details relatifs au produit dont l'id a ete specifie
        $detail = AmazonProduitDetail::where('produit_id', $id)->first();

        return view('produit_details', [
            'details' => $detail
        ]);
    }
}
