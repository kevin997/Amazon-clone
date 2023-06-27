<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Summary of createProfile
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        
        // validation des donnees
        $request->validate([
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required'
        ]);

        try {
            // traitement des donnees
            $profil = new UserProfile();

            $profil->phone = $request->phone;
            $profil->country = $request->country;
            $profil->city = $request->city;
            $profil->street_address = $request->street_address;
            $profil->zip = $request->zip;
            $profil->image = isset($request->image)? $request->image : '';
            $profil->user_id = Auth::user()->id;
            $profil->save();

            return response()->json([
                'status_code' => 1,
                'message' => 'profil sauvegarde avec succes.',
                'profil' => $profil
            ], 200);

            // redirection vers dashboard
            //........
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id){
        // on recupere l'id de l'utilisateur connecte
        $user_id = Auth::user()->id;

        // on verifie que le profil a mettre a jour existe
        if(UserProfile::where(['id' => $id, 'user_id' => $user_id])->exists()){
            
            // on recupere l'enregistrement concerne
            $profil = UserProfile::where(['id' =>$id, 'user_id' => $user_id])->first();

            // on valide le format des donnees
            $request->validate([
                'phone' => 'required',
                'country' => 'required',
                'city' => 'required'
            ]);
                        
            try {
                // on lance la mise a jour
                $profil->update([
                    'phone' => $request->phone,
                    'country' => $request->country,
                    'city' => $request->city,
                    'street_address' => $request->street_address,
                    'zip' => $request->zip,
                    'image' => $request->image
                ]);
    
                return response()->json([
                    'status_code' => 1,
                    'message' => 'profil sauvegarde avec succes.',
                    'profil' => $profil
                ], 200);
    
                // redirection vers dashboard
                //........
            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                'status_code' => 0,
                'message' => 'profil inexistant.'
            ], 404);
        }
    }

    public function edit($id){

        // on compare par securite l'id de l'utilisateur connecte a celui fourni par l'url
        $user_id = Auth::user()->id;
        $user_name =Auth::user()->name;

        // on verifie qu'un profil existe pour l'utilisateur connecte
        if(UserProfile::where(['id' =>$id, 'user_id' => $user_id])->exists()){

            // on recupere les informations de profil            
            $info = UserProfile::where(['id' =>$id, 'user_id' => $user_id])->get();

            return response()->json([
                'status_code' => 1,
                'message' => 'Informations de profil de '.$user_name,
                'profil' => $info
            ], 200);
        }else{
            return response()->json([
                'status_code' => 0,
                'message' => 'Pas de profil defini pour ce compte '
            ], 404);
        }       
    }

    public function delete($id){
        // on recupere l'id de l'utilisateur connecte
        $user_id = Auth::user()->id;

        // on compare par securite l'id de l'utilisateur connecte a celui fourni par l'url
        if(UserProfile::where(['id' =>$id, 'user_id' => $user_id])->exists()){
            // on lance la mise a jour
            try {                
                $profil = UserProfile::where(['id' =>$id, 'user_id' => $user_id])->first();
                $profil->delete();

                return response()->json([
                    'status_code' => 1,
                    'message' => 'Informations de profil supprimees avec success.'
                ], 200);
    
                // redirection vers dashboard
                //........
            } catch (Exception $e) {
                return response()->json($e);
            }
        }else{
            return response()->json([
                'status_code' => 0,
                'message' => 'Pas de profil pour ce compte.'
            ], 404);
        }
        
    }
}
