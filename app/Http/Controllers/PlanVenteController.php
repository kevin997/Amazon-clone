<?php

namespace App\Http\Controllers;

use App\Models\AmazonPlanVente;
use App\Models\User;
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
        // afficher tous les plans
        $plan_ventes = AmazonPlanVente::all();

        return view('plans_vente', [
            'liste_plans' => $plan_ventes
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
                "name" => "required|unique:amazon_plan_ventes,name",
                "montant" => "required",
                "details" => "required",
            ]);

            try {
                //traitement des donnees
                $plan_vente = new AmazonPlanVente();
                $plan_vente->name = $request->name;
                $plan_vente->details = $request->details;
                $plan_vente->montant = $request->montant;
                $plan_vente->created_at = now();
                $plan_vente->save();

                return response()->json([
                    "status_code" => 1,
                    "message" => "Ajout du plan de vente reussie.",
                    "plan_vente" => $plan_vente,
                    "role" => $user_infos->hasRole('Admin')
                ], 201);

                // redirection vers le formulaire de saisie
                //........

            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                "status_code" => 0,
                "message" => "Vous devez detenir les habilitations d'administrateur pour ajouter un plan de vente.",
                "role" => $user_infos->hasRole('Admin')
            ], 406);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // on recupere les informations relative au plan de vente dont on a specifie l'id
        $plan_vente = AmazonPlanVente::where('id', $id)->first();

        return view('plan_vente', [
            'plan_vente' => $plan_vente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Prevue pour editer un plan
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validation des donnees
        $request->validate([
            "name" => "required|unique:amazon_plan_ventes,name",
            "montant" => "required",
            "details" => "required",
        ]);

        // on charge le plan de vente a mettre a jour
        $plan_vente = AmazonPlanVente::where('id', $id)->first();

        try {
            //traitement des donnees
            $plan_vente->update([
                "name" => $request->name,
                "details" => $request->details,
                "montant" => $request->montant,
                "updated_at" => now()
            ]);
            
            return response()->json([
                "status_code" => 1,
                "message" => "Ajout du plan de vente reussie.",
                "plan_vente" => $plan_vente
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
            // on supprime le pln de vente
            $plan_vente->delete();

            return response()->json([
                "status_code" => 1,
                "message" => "Suppression du plan de vente ".$plan_vente->name." reussie."
            ], 200);

        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
