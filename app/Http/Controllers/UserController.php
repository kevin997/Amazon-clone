<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function register(Request $request){
        
        //validation des donnees
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required|confirmed|min:8",
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required'
        ]);

        try {
            // traitement des donnees
            //-------------- 1- ENREGISTREMENT D'UN NOUVEL UTILISATEUR -----------------
            $new_user = new User();
            $new_user->name = $request->name;
            $new_user->email = $request->email;
            $new_user->password = Hash::make($request->password, ['rounds' => 12]);
            $new_user->save();
            
            // on recupere l'id correspondant au role <<customer>>
            $role = Role::where('name', 'Customer')->first();         
            
            // on assigne le role au nouvel utilisateur
            $new_user->assignRole($role->id);

            // envoi du mail de verification
            $new_user->sendEmailVerificationNotification();


            //-------------- 2- AJOUT DES INFOS DU PROFIL -----------------
            $user = User::find($new_user->id);

            // photo de profil
            $image = isset($request->image)? $request->image : 'no image';

            $profil = new UserProfile();

            $profil->phone = $request->phone;
            $profil->country = $request->country;
            $profil->city = $request->city;
            $profil->street_address = $request->street_address;
            $profil->zip = $request->zip;
            $profil->image = $image;
            
            $user->user_profile()->save($profil);

            // redirection vers login
            return redirect('/login')->with(['message' => 'Compte creer avec succes. Un email de verification vous a ete envoye pour valider votre compte.'], 406);
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
                // creer un jeton/token
                $token = $user->createToken("auth_token")->plainTextToken;
                
                // connexion reussie
                return response()->json([
                    "status_code" => 1,
                    "message" => "Connexion reussie",
                    "user" => $user,
                    "role_name" => $user->getRoleNames(),
                    "access_token" => $token
                ], 201);

                // redirection vers le dashboard correspondant
                // return redirect('/dashboard');              

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

    public function logout(Request $request){
        //recuperation des informations de l'utilisateur actuel connecte
        Auth::user()->tokens()->delete();

        // deconnexion reussie
        return response()->json([
            "status_code" => 1,
            "message" => "Deconnexion reussie",
        ]);

        // redirection vers index
        // return redirect('/home');

    }

    public function updateProfile(Request $request){

        //validation des donnees
        $request->validate([
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required'
        ]);

        try {
            // traitement des donnees
            $user = User::find($request->id);

            // y a t-il une photo de profil ?
            $image = isset($request->image)? $request->image : 'no image';

            $profil = new UserProfile();

            $profil->phone = $request->phone;
            $profil->country = $request->country;
            $profil->city = $request->city;
            $profil->street_address = $request->street_address;
            $profil->zip = $request->zip;
            $profil->image = $image;
            
            $user->user_profile()->save($profil);

            // redirection vers login
            return redirect('/dashboard')->with(['message' => 'Profil du compte mis a jour avec succes.'], 406);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function editProfile($id){

    }

    public function deleteProfile($id){

    }
}
