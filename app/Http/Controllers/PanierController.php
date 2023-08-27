<?php

namespace App\Http\Controllers;

use App\Models\AmazonPanier;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function AjouterLignePanier(Request $request){

        // on recupere les informations d'authentification
        $user_connected = Auth::user();

        // Quel est le role de l'utilisateur connecte ?
        $user = User::where('id', $user_connected->id)->first();

        if($user->hasRole(['Admin', 'Customer'])){
            
            // l'utilisateur connecte dispose t-il d'un panier actif ?
            $panier = AmazonPanier::where(['user_id' => $user->id, 'etat' => 'actif'])->first();

            if(!$panier){
                
                //--------- 1- CREATION DU PANIER CLIENT
                try {
                    // traitement des donnees
                    $panier = new AmazonPanier();
                    $panier->user_id = $user->id;
                    $panier->name = "Panier nº " . random_int(100000000, 999999999) . " de " . $user->name;
                    $panier->etat = "actif";    
                    $panier->save();                    

                } catch (Exception $e) {
                    return response()->json($e);
                }
            }
            
            //--------- 2- AJOUT/MISE A JOUR DE LA LIGNE PANIERS_PRODUITS
            $product_found = $panier->produits()->where('produit_id', $request->produit_id)->count();

            if($product_found > 0){
                // un prix de vente a t-il ete specifie ?
                $prix_vente = !isset($request->prix_vente)? 0 : $request->prix_vente;

                // mise a jour la ligne
                $panier->produits()->updateExistingPivot($request->produit_id, [
                    'quantite_commandee' => $request->quantite_commandee,
                    'prix_vente' => $prix_vente,
                    'updated_at' => now()
                ]);

                $message = "L'article  ete modifie avec succes.";
            }else{
                // un prix de vente a t-il ete specifie ?
                $prix_vente = !isset($request->prix_vente)? 0 : $request->prix_vente;

                // on ajoute la ligne
                $panier->produits()->attach($request->produit_id, [
                    'quantite_commandee' => $request->quantite_commandee,
                    'prix_vente' => $prix_vente,
                    'created_at' => now()
                ]);

                $message = "L'article  ete ajoute avec succes.";
            }           

            // Retour au catalogue des produits
            return response()->json([
                'status' => 1,
                'message' => $message,
                'panier_produits' => $panier->produits()->get()
            ], 201);

        }else{
            // Vous devez vous authentifier
            return redirect('login')->with('message', 'Vous devez vous authentifier');
        }
    }

    // Pour supprimer une ligne dans le panier
    public function SupprimerLignePanier(Request $request){

        $panier = AmazonPanier::find($request->panier_id);

        // on detache la ligne transmise en parametre
        $panier->produits()->detach($request->produit_id);
        
        // redirection vers le catalogue des produits
        return redirect('catalogue/product')->with('message', 'Ligne supprimee.');
    }

    // Pour vider le panier
    public function ViderPanier(Request $request){

        $panier = AmazonPanier::find($request->panier_id);

        // on detache la ligne transmise en parametre
        $panier->produits()->detach();
        
        // redirection vers le catalogue des produits
        return redirect('catalogue/product')->with('message', 'Panier vide.');
    }

    public function ValiderPanier(Request $request){
        
        //--------- 1- MISE A JOUR DU STATUT DU PANIER (etat = 'valide')
        $panier = AmazonPanier::find($request->panier_id);

        $panier->update([
            'etat' => 'valide'
        ]);

        //--------- 2- REDIRECTION VERS INTERFACE COMMANDE (adresse facturation - livraison - mode paiement)
        return redirect("orders/place_order/{".$request->panier_id."}")->with('message', 'Renseignez less adresses de facturation et de livraison de votre commande.');
    }
}
