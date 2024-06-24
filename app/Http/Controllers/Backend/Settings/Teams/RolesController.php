<?php

namespace App\Http\Controllers\Backend\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Models\Settings\Teams\Administrator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.settings.teams.roles.index', [
            'roles' => Role::orderBy('id','DESC')->where('id', '!=', '1')->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = new Role();
        $all_permissions = Permission::all();
        $permission_groups = Administrator::getpermissionGroups();
        return view('backend.settings.teams.roles.form', compact('role', 'all_permissions', 'permission_groups'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'permissions' => 'required',
        ]);
        $role = Role::create(['name' => $request->name]);
        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }
        return redirect()->route('backend.settings.teams.index')
            ->withSuccess('Le nouveau rôle a été ajouté avec succès.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $all_permissions = Permission::all();
        $permission_groups = Administrator::getpermissionGroups();
        return view('backend.settings.teams.roles.form', compact('role', 'all_permissions', 'permission_groups'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'permissions' => 'required',
        ]);
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Le rôle a été mis à jour avec succès.');
        return back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role->name=='SuperAdmin'){
            abort(403, 'LE ROLE DE SUPER ADMIN NE PEUT PAS ÊTRE SUPPRIMÉ');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'IMPOSSIBLE DE SUPPRIMER LE ROLE AUTO-ATTRIBUÉ');
        }
        $role->delete();
        return redirect()->route('backend.settings.teams.index')
            ->withSuccess('Le rôle a été supprimé avec succès.');
    }
    public static function renamePermission(string $name)
    {
        return str_replace('-', ' -> ', $name);
    }
}
