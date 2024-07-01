<?php

namespace App\Http\Controllers\Backend\Clients;

use App\Http\Controllers\Controller;
use App\Models\Users\Groups;
use Illuminate\Http\Request;

class ClientsGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.clients.groups.index', [
            'groups' => Groups::orderBy('id','DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $group = new Groups();
        return view('backend.clients.groups.form', [
            'group' => $group,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255|nullable',
            'erp_id' => 'string|max:255|nullable',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active']=='on' ? 1:0;
        $group = Groups::create($validated);
        return redirect()->route('backend.clients.groups.edit', $group)->withSuccess('Groupes ajouter avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groups $group)
    {
        return view('backend.clients.groups.form', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Groups $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255|nullable',
            'erp_id' => 'string|max:255|nullable',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active']=='on' ? 1:0;
        $group->update($validated);
        return back()->withSuccess('Groupe modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groups $group)
    {
        $group->delete();
        return to_route('backend.clients.groups.index');
    }
}
