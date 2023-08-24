<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\AmazonStore;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BecomeSellerController extends Controller
{
    public function createStore(Request $request){
        // utilisateur logge ?
        $user_connected = Auth::user();        

        
        if($user_connected){    // Pour les detenteurs de compte amazon

            // 1- Assignation du role vendeur <<seller>> ------
            //-------------------------------------------

            // infos utilisateur
            $user = User::where('id', $user_connected->id)->first();

            // Pas encore vendeur
            if(!($user->hasRole('Seller'))){ 
                
                // on supprime d'abord le role acheteur <<Customer>>
                $user->removeRole('Customer');

                // on recupere l'id du role <<Seller>>
                $role = Role::where('name', 'Seller')->first();                

                // on assigne le role vendeur <<Seller>>
                $user->assignRole($role->id);


                // 2- Creation de la boutique (store) -------
                //-------------------------------------------

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
                        "message" => "Operation reussie, vous etes desormais vendeur sur Amazon.",
                        "store" => $store
                    ], 201);
                    
                    // 3- redirection vers enregistrement infos paiement
    
                } catch (Exception $e) {
                    return response()->json($e);
                }

            }else{
                // Deja vendeur
                return response()->json([
                    'status' => 0,
                    'message' => "Desole, vous avez deja le statut de vendeur."
                ], 406);
            }            
        }else{
            // Pas encore inscrit sur Amazon
            return response()->json([
                'status' => 0,
                'message' => "Vous devez d'abord vous inscrire pour acceder a cette fonctionnalite."
            ], 404);
        }

    }
}
