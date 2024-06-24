<?php

namespace App\Http\Controllers\Backend\Settings\Teams;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\settings\Teams\AdministratorsRequest;
use App\Models\Settings\Teams\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdministratorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index()
    {
        return view('backend.settings.teams.administrators.index', [
            'admins' => Administrator::orderBy('id','DESC')->where('id', '!=', '1')->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin = new Administrator();
        return view('backend.settings.teams.administrators.form', [
            'administrator' => $admin,
            'roles' => Role::pluck('name')->all()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'roles' => 'required'
        ]);
        $validated['password'] = Hash::make($request->password);

        $admin = Administrator::create($validated);
        $admin->assignRole($request->roles);

        return redirect()->route('backend.settings.teams.index')
            ->withSuccess('Le nouvel administrateur a été ajouté avec succès.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrator $administrator)
    {
        // Check Only Super Admin can update his own Profile
        if ($administrator->hasRole('SuperAdmin')){
            if($administrator->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('backend.settings.teams.administrators.form', [
            'administrator' => $administrator,
            'roles' => Role::pluck('name')->all(),
            'roles_is' => Role::pluck('id')->all(),
            'userRoles' => $administrator->roles->pluck('name')->all()
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Administrator $administrator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'roles' => 'required'
        ]);
        $administrator->syncRoles($request->roles);
        $administrator->update($validated);
        return redirect()->route('backend.settings.teams.index')
            ->withSuccess("L'administrateur a été modifié avec succès.");
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrator $administrator)
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($administrator->hasRole('SuperAdmin') || $administrator->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $administrator->syncRoles([]);
        $administrator->delete();
        return redirect()->route('backend.settings.teams.index')
            ->withSuccess('L\'administrateur a été supprimé avec succès.');
    }
    /**
     * Changer le mot de passe de l'utilisateur
     */
    public function changeMDP(Request $request, $id)
    {
        if(!empty($request->password)){
            $newpassword = Hash::make($request->password);
        }
        $administrateur = Administrator::find($id);
        $administrateur->password = $newpassword;
        $administrateur->update();
        return redirect()->route('backend.settings.teams.index')
                ->withSuccess('Le mot de passe de l\'administrateur a été modifié avec succès.');
    }
}
