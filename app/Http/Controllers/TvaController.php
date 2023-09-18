<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AmazonTva;
use Exception;

class TvaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tva = AmazonTva::all()->orderBy('taux')->get();

        return view('grille_tva',[
            'tableau_tva' => $tva
        ]);
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
    public function store(Request $request)
    {        
        // validation des donnees
        $request->validate([
            "taux" => "required|decimal:2",
            "description" => "required|unique:amazon_tva,description"
        ]);

        try {
            // traitement des donnees
            $new_tva = new AmazonTva();

            $new_tva->taux = $request->taux;
            $new_tva->description = $request->description;
            $new_tva->created_at = now();

            $new_tva->save();

            return redirect('/show_grille_tva')->with(['message' => 'Nouveau taux TVA cree avec succes.']);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('show_grille_tva');
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
    public function update(Request $request)
    {
        // validation des donnees
        $request->validate([
            "taux" => "required|decimal:2",
            "description" => "required"
        ]);

        try {
            // traitement des donnees
            $tva = AmazonTva::find($request->id);

            $tva->update([
                'taux' => $request->taux,
                'description' => $request->description,
                'updated_at' => now()
            ]);

            return redirect('/grille_tva')->with(['message' => 'Mise a jour taux TVA reussie.']);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            // traitement des donnees
            $tva = AmazonTva::find($id);
            $tva->delete();

            return redirect('/grille_tva')->with(['message' => 'Suppression taux TVA reussie.']);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
