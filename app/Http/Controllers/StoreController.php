<?php

namespace App\Http\Controllers;

use App\Models\AmazonStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class StoreController extends Controller
{
    public function create(Request $request){
        $user = Auth::user();

        // validation des donnees
        $request->validate([
            "nom" => "required|unique:amazon_stores,nom",
            "adresse" => "required",
            "pays" => "required",
            "code_postal" => "required",
            "site_web" => "required|url",
        ]);

        try {
            // traitement des donnees
            $store = new AmazonStore();
            $store->user_id = $user->id;
            $store->nom = $request->nom;
            $store->adresse = $request->adresse;
            $store->pays = $request->pays;
            $store->code_postal = $request->code_postal;
            $store->etat = "en attente";
            $store->site_web = $request->site_web;
            $store->localisation = isset($request->localisation)? $request->localisation : "Pas encore de localisation.";                                                
            $store->logo = isset($request->logo)? $request->logo : "Pas encore de logo";

            $store->save();

            return response()->json([
                "status_code" => 1,
                "message" => "Creation de la boutique de ".$user->name." reussie.",
                "store" => $store
            ], 201);
            
            // 3- redirection vers enregistrement infos paiement

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id){
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
                ], 200);

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

    public function close($id){

        // on recupere l'id de l'utilisateur connecte
        $user = Auth::user();

        // on s'assure que le store a supprimer appartient a l'utilisateur connecte
        $found = AmazonStore::where(['id'=>$id, 'user_id'=>$user->id])->exists();

        if($found){
            // on recupere le store
            $store = AmazonStore::where('id', $id)->first();

            try {
                // on desactive le store (etat='desactive')
                $store->update([
                    'etat' => 'desactivee', 
                    'modifie_le' => now()
                ]);

                return response()->json([
                    "status_code" => 1,
                    "message" => "Fermeture de la boutique ".$store->nom." reussie.",
                    "store" => $store
                ], 200);

            } catch (Exception $e) {
                return response()->json($e);
            }            
        }else{      // Pas de correspondance trouvee
            return response()->json([
                "status_code" => 0,
                "message" => "Operation impossible!!! vous n'etes pas le proprietaire de cette boutique.",
            ], 404);
        }
    }

    public function delete($id){
        // exclusivement reservee a l'administrateur

        // on s'assure que le store a supprimer appartient a l'utilisateur connecte
        $store = AmazonStore::where(['id'=>$id])->first();

        try {
            // on desactive le store (etat='desactive')
            $store->delete();

            return response()->json([
                "status_code" => 1,
                "message" => "Suppression de la boutique ".$store->nom." reussie.",
                "store" => $store
            ], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function edit($id){

        $user = Auth::user();
        $store = AmazonStore::where('user_id', $id)->get();

        return response()->json([
            "status_code" => 1,
            "message" => "Liste des boutiques de ".$user->name,
            "store" => $store
        ], 200);

    }
}
