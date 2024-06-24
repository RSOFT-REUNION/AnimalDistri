<?php

namespace App\Http\Controllers\Backend\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Shop;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.catalog.shops.index', [
            'shops' => Shop::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shops = new Shop();
        return view('backend.catalog.shops.form', [
            'shops' => $shops
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255|string',
            'address' => 'string|nullable',
            'postal_code' => 'string|nullable',
            'city' => 'string|nullable',
            'description' => 'string|nullable',
            'schedules' => 'string|nullable',
            'visibility' => 'nullable',
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active'] == 'on' ? 1 : 0;
        if ($request->hasFile('image')) {
            $imageName = Str::slug($validated['image']->getClientOriginalName(), '.');
            $validated['image']->storeAs('public/upload/catalog/shops', $imageName);
            $validated['image'] = $imageName;
        }
        Shop::create($validated);
        return redirect()->route('backend.catalog.shops.index')->withSuccess('Magasin ajouté avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        return view('backend.catalog.shops.form', [
            'shops' => $shop
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255|string',
            'address' => 'string|nullable',
            'postal_code' => 'string|nullable',
            'city' => 'string|nullable',
            'description' => 'string|nullable',
            'schedules' => 'string|nullable',
            'visibility' => 'nullable',
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active'] == 'on' ? 1 : 0;
        if (@$validated['image']) {
            /*** Suppresion de l'ancienne image ***/
            $old = Shop::select('image')->where('id', $shop->id)->first();
            Storage::delete('public/upload/catalog/shops/' . $old->image);
            /*** ***/
            $imageName = Str::slug($validated['image']->getClientOriginalName(), '.');
            $validated['image']->storeAs('public/upload/catalog/shops/', $imageName);
            $validated['image'] = $imageName;
            Shop::where('id', $shop->id)->update($validated);
            return back()->withSuccess('Magasin modifié avec succès');
        } else {
            Shop::where('id', $shop->id)->update($validated);
            return back()->withSuccess('Magasin modifié avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        Storage::delete('public/upload/catalog/shops/' . $shop->image);
        $shop->delete();
        return back()->withSuccess('Magasin supprimé avec succès');
    }
}
