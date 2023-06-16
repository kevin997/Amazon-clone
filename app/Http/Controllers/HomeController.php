<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class HomeController extends Controller
{
    public function addRole(Request $request){
        // creation de roles
        $role = Role::create(['name' => $request->name]);

        if($role){
            return response()->json([
                'status' => 1,
                'message' => 'role creer avec succes'
            ], 200);
        }else{
            return response()->json([
                'status' => 0,
                'message' => 'impossible de creer le role'
            ]);
        }
    }

    public function addPermission(Request $request){
        // creation de roles
        $permission = Permission::create(['name' => $request->name]);

        if($permission){
            return response()->json([
                "status" => 1,
                "message" => "permission creer avec succes"
            ], 200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "impossible de creer la permission"
            ]);
        }
    }

    public function assignPermissionToRole(Request $request){
        // recuperation des donnees postees
        $permission = Permission::where('name', $request->perm_name)->first();
        $role = Role::where('name', $request->role_name)->first();

        // assignation des permissions a un role
        $done = $role->givePermissionTo($permission);

        if($done){
            return response()->json([
                "status" => 1,
                "message" => "Assignation reussie."
            ], 200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Echec d'assignation de permission."
            ]);
        }
    }

    public function assignRoleToUser(Request $request){
        // recuperation des donnees postees
        $user = User::where('email', $request->email)->first();
        $role = Role::where('name', $request->name)->first();

        // assignation du role
        
        $done = $user->assignRole($role);

        if($done){
            return response()->json([
                "status" => 1,
                "message" => "Assignation reussie."
            ], 200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Echec d'assignation de role."
            ]);
        }
    }

    public function showRoles(){
        // selection de tous les roles
       $tab_roles = Role::all();

       // affichage dans la vue dediee
       return view('auth.roles_view', ['role' => $tab_roles]);
    }

    public function showPermissions(){
        // selection de tous les roles
       $tab_perms = Permission::all();

       // affichage dans la vue dediee
       return view('auth.permissions_view', ['role' => $tab_perms]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
