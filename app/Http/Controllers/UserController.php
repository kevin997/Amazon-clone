<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function register(Request $request){
        
        //validation des donnees
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required|confirmed|min:8"
        ]);

        try {
            // traitement des donnees
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, ['rounds' => 12]);
            $user->save();

            // envoi du mail de verification
            $user->sendEmailVerificationNotification();

            return response()->json([
                "status_code" => 200,
                "status_message" => "Compte creer avec succes.",
                "user" => $user
            ]);

            // redirection vers le dashboard correspondant
                //......
        } catch (Exception $e) {
            //throw $th;
            return response()->json($e);
        }
    }

    public function login(Request $request){
        //validation des donnees
        $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required"
        ]);

        // recuperer les infos de l'utilisateur s'il existe 
        $user = User::where("email", "=", $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                // creer un jeton/token
                $token = $user->createToken("auth_token")->plainTextToken;
                
                // connexion reussie
                return response()->json([
                    "status_code" => 1,
                    "message" => "Connexion reussie",
                    "user" => $user,
                    "access_token" => $token
                ], 201);

                // redirection vers le dashboard correspondant
                //......              

            }else{
                return response()->json([
                    'status_code' => 0,
                    'status_message' => 'Mot de passe incorrect'
                ], 401);
            }
        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Compte inexistant'
            ], 404);
        }

    }

    public function verify(Request $request){
        $user = User::findOrFail($request->id);

        if ($user->email_verified_at) {
            return '';
        }
    
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
    
        return redirect()->away('app://open'); // The deep link
    }    
}
