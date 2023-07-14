<?php

namespace App\Http\Controllers;

use App\Models\AmazonPlanVente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanVenteController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // on verifie qu'il s'agit de l'admistrateur
        $role = Auth::user()->role;

        if($role == "admin"){
            // validation des donnees
            $request->validate([
                "name" => "required|unique:amazon_plan_vente,name",
                "forfait" => "required",
                "details" => "required",
            ]);

            try {
                //traitement des donnees
                $plan_vente = new AmazonPlanVente();
                $plan_vente->name = $request->name;
                $plan_vente->details = $request->details;
                $plan_vente->forfait = $request->forfait;
                $plan_vente->created_at = now();
                $plan_vente->save();

                return response()->json([
                    "status_code" => 1,
                    "message" => "Ajout du plan de vente reussie.",
                    "plan_vente" => $plan_vente
                ], 201);

                // redirection vers le formulaire de saisie
                //........

            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                "status_code" => 0,
                "message" => "Impossible d'ajouter le plan de vente.",
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // on affiche la liste des plans de vente
        $plan_vente = AmazonPlanVente::all();

        return response()->json([
            "status_code" => 1,
            "message" => "Liste des plans de vente",
            "store" => $plan_vente
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validation des donnees
        $request->validate([
            "name" => "required|unique:amazon_plan_vente,name",
            "forfait" => "required",
            "details" => "required",
        ]);

        // on charge le plan de vente a mettre a jour
        $plan_vente = AmazonPlanVente::where('id', $id)->first();

        try {
            //traitement des donnees
            $plan_vente->update([
                "name" => $request->name,
                "details" => $request->details,
                "forfait" => $request->forfait,
                "updated_at" => now()
            ]);
            
            return response()->json([
                "status_code" => 1,
                "message" => "Ajout du plan de vente reussie.",
                "store" => $plan_vente
            ], 200);

            // redirection vers la liste des plans de vente
            //........

        } catch (Exception $e) {
            return response()->json($e);
        }

        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // on recupere le plan de vente a supprimer
        $plan_vente = AmazonPlanVente::where('id', $id)->first();

        try {
            // on desactive le store (etat='desactive')
            $plan_vente->delete();

            return response()->json([
                "status_code" => 1,
                "message" => "Suppression du plan de vente ".$plan_vente->name." reussie.",
                "store" => $plan_vente
            ], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
