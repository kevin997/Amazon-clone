<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        
        // validation des donnees
        $request->validate([
            'name' =>'required',
            'email' =>'required|email|unique:users',
            'password' =>'required|confirmed'
        ]);

        // traitement des donnes
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->password = Hash::make($request->password);
        $user->save();

        // reponse
        return response()->json([
            'status' => 1,
            'message' => 'compte creer avec succes'
        ]);
    }

    public function login(Request $request){
        // validation des donnees
        $request->validate([
            'email' =>'required|email',
            'password' =>'required'
        ]);

        // verifier si l'utilisateur existe
        $user = User::where('email', '=', $request->email)->first();

        if($user){
            if(Hash::check($request->email, $user->email)){
                // creer un jeton/token
                $token = $user->createToken('auth_token')->plainTextToken;

                // connexion reussie
                return response()->json([
                    'status' => 1,
                    'message' => 'Connexion reussie',
                    'access_token' => $token
                ], 200);

                // redirection vers le dashboard correspondant

            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'Mot de passe incorrect'
                ]);
            }

        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Compte inexistant'
            ], 404);
        }

    }

    public function logout($id){
        
    }

    public function becomeSeller($id){
        
    }

    public function UpdateProfile($id){
        
    }

    public function profile(Request $request){

        return response()->json([
            "status" => 1,
            "message" => "Vos informations de prfile",
            "datas" => Auth::user()
        ]);

        // redirection vers l'interface d'affichage
        
    }
}
