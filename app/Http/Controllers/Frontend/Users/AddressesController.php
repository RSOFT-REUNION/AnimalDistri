<?php

namespace App\Http\Controllers\Frontend\Users;

use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Models\Users\Address;
use App\Models\Users\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\NoSemicolon;

class AddressesController extends FrontendBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.profile.partials.address', [
            'address' => Address::where('user_id', '=', Auth::user()->id)->get(),
            'cities' => Cities::orderBy('city')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $adresse = new Address();
        $cities = Cities::orderBy('city')->get();
        return view('frontend.profile.partials.address_form', [
            'adresse' => $adresse,
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alias' => ['required', 'string', 'min:3', 'max:255', new NoSemicolon],
            'civility' => ['required', new NoSemicolon],
            'first_name' => ['required', 'string', 'max:255', new NoSemicolon],
            'last_name' => ['required', 'string', 'max:255', new NoSemicolon],
            'address' => ['required', 'string', 'max:255', new NoSemicolon],
            'address2' => ['max:255', new NoSemicolon],
            'other' => ['max:255', new NoSemicolon],
            'cities' => ['required', new NoSemicolon],
            'country' => ['nullable', new NoSemicolon],
            'phone' => ['required', 'string', 'max:20', new NoSemicolon],
            'other_phone' => ['max:20', new NoSemicolon],
            'favorite' => '',
        ]);
        $validated['user_id'] = Auth::user()->id;
        $validated['country'] = "La Réunion";
        Address::create($validated);
        return redirect()->route('address.index')->withSuccess('Adresse ajouté avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $mes_adress)
    {
        $cities = Cities::orderBy('city')->get();
        return view('frontend.profile.partials.address_form', [
            'adresse' => $mes_adress,
            'cities' => $cities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $mes_adress)
    {
        $validated = $request->validate([
            'alias' => ['required', 'string', 'min:3', 'max:255', new NoSemicolon],
            'civility' => ['required', new NoSemicolon],
            'first_name' => ['required', 'string', 'max:255', new NoSemicolon],
            'last_name' => ['required', 'string', 'max:255', new NoSemicolon],
            'address' => ['required', 'string', 'max:255', new NoSemicolon],
            'address2' => ['max:255', new NoSemicolon],
            'other' => ['max:255', new NoSemicolon],
            'cities' => ['required', new NoSemicolon],
            'country' => ['nullable', new NoSemicolon],
            'phone' => ['required', 'string', 'max:20', new NoSemicolon],
            'other_phone' => ['max:20', new NoSemicolon],
            'favorite' => '',
        ]);
        $validated['user_id'] = Auth::user()->id;
        $validated['country'] = "La Réunion";
        Address::where('id', $mes_adress->id)->update($validated);
        return back()->withSuccess('Adresse modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $mes_adress)
    {
        $mes_adress->delete();
        return back()->withSuccess('Adresse supprimée avec succès');
    }

    public function fav_address(Address $address)
    {
        Address::where('user_id', Auth::user()->id)->update(['favorite' => '']);
        $address->favorite = $address->id;
        $address->save();
        return view('frontend.profile.partials.address_list', [
            'address' => Address::where('user_id', '=', Auth::user()->id)->get(),
            'cities' => Cities::orderBy('city')->get()
        ]);
    }
}
