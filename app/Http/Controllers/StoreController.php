<?php

namespace App\Http\Controllers;

use App\Models\AmazonStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class StoreController extends Controller
{
    public function update(Request $request, $id)
    {
        //user connecte
        $user_id = Auth::user()->id;
        
        // on verifie que le store existe et appartient effectivement a l'utilisateur connecte
        $found = AmazonStore::where(['id' => $id, 'user_id' => $user_id])->exists();

        if($found){     // store trouve

            // on recupere le store a modifier
            $store = AmazonStore::where(['id'=>$id, 'user_id'=>$user_id])->first();

            // validation des donnees
            $request->validate([
                "nom" => "required",
                "adresse" => "required",
                "pays" => "required",
                "code_postal" => "required",
                "site_web" => "required|url",
            ]);

            try {
                // traitement des donnees
                $store->update([
                    'nom' => $request->nom,
                    'adresse' => $request->adresse,
                    'pays' => $request->pays,
                    'code_postal' => $request->code_postal,
                    'site_web' => $request->site_web,
                    'localisation' => $request->localisation,
                    'logo' => $request->logo,
                    'etat' => isset($request->etat)? $request->etat : "en attente",
                    'modifie_le' => now()
                ]);                

                return response()->json([
                    "status_code" => 1,
                    "message" => "Mise a jour de la boutique reussie.",
                    "store" => $store
                ], 201);

                // redirection vers dashboard
                //........
            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{      // store non trouve
            return response()->json([
                "status_code" => 0,
                "message" => "Mise a jour impossible!!! vous n'etes pas le proprietaire de cette boutique.",
            ], 404);
        }
    }
}
