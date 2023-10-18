<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        $users =  User::all();

        return response()->json([
            "status_code" => 0,
            "message" => "ok",
            "results" => $users
        ], 200);

    }

    // to subscribe
    public function register(Request $request){

        //validation des donnees
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required|confirmed|min:8",
        ]);

        try {
            // traitement des donnees
            //-------------- 1- ENREGISTREMENT D'UN NOUVEL UTILISATEUR -----------------
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, ['rounds' => 12]);
            $user->save();

            // on recupere l'id correspondant au role <<customer>>
            $role = Role::where('name', 'Customer')->first();

            // on assigne le role au nouvel utilisateur
            $user->assignRole($role->id);
            
            // redirection vers login
            return response()->json([
                "status_code" => 0,
                "user" => $user,
                "message" => "Votre compte a ete cree avec succes. Un email de verification via l'adresse specifiee pour valider votre compte."
            ], 200);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function login(Request $request){

        //validation des donnees
        $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required",
        ]);

        // recuperer les infos de l'utilisateur s'il existe
        $user = User::where("email", $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $expires_at = new DateTime();
                $expires_at->modify("+120 minute");

                //$expires_at = date("Y-m-d H:i:s", time()+(3*3600));

                // creer un jeton/token                
                $token = $user->createToken("auth_token", ['*'], $expires_at)->plainTextToken;
                
                // connexion reussie
                return response()->json([
                    "status_code" => 1,
                    "message" => "Connexion reussie",
                    "user" => $user,
                    "role_name" => $user->getRoleNames(),
                    "access_token" => $token,
                    "expires_token" => $expires_at
                ], 201);

            }else{
                return response()->json([
                    'status_code' => 0,
                    'message' => 'Mot de passe incorrect'
                ], 401);
            }
        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Compte inexistant'
            ], 404);
        }

    }


    public function logout(){

        //on recupere l'utilisateur connecte
        $user = Auth::user();

        if(!$user){
            return response()->json([
                "status_code" => 0,
                "errors" => 401,
                "message" => "utilisateur non trouve"
            ]);
        }else{
            try {
                $user->tokens()->delete();

                // deconnexion reussie
            return response()->json([
                "status_code" => 1,
                "errors" => 200,
                "message" => "Deconnexion reussie",
                "user" => $user
            ]);
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
    }

    public function update(Request $request, $id){

        //validation des donnees
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        try {
            // traitement des donnees
            $user = User::find($id);

            if(!$user){
                return response()->json([
                    "status_code" => 0,
                    "message" => "Utilisateur inexistant.",
                ], 404);
            }

            $user->update([
                "name" => $request->name,
                "email" => $request->email,
                "updated_at" => now()
            ]);            

            return response()->json([
                "status_code" => 1,
                "message" => "Utilisateur mis a jour avec succes."
            ], 200);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id){

        try {
            // traitement des donnees
            $user = User::find($id);

            if(!$user){
                return response()->json([
                    "status_code" => 0,
                    "message" => "Utilisateur inexistant.",
                ], 404);
            }

            return response()->json([
                "status_code" => 1,
                "user" => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function edit($id){

        try {
            // traitement des donnees
            $user = User::find($id);

            if(!$user){
                return response()->json([
                    "status_code" => 0,
                    "message" => "Utilisateur inexistant.",
                ], 404);
            }

            return response()->json([
                "status_code" => 1,
                "user" => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id){

        try {
            // traitement des donnees
            $user = User::find($id);

            if(!$user){
                return response()->json([
                    "status_code" => 0,
                    "message" => "Utilisateur inexistant.",
                ], 404);
            }

            $user->delete();

            return response()->json([
                "status_code" => 1,
                "message" => "Utilisateur supprime avec succes.",
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
