<?php

namespace App\Http\Controllers\Backend\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;
use App\Models\Catalog\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.catalog.brands.index', [
            'brands' => Brand::orderBy('id','DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = new Brand();
        return view('backend.catalog.brands.form', [
            'brands' => $brands,
            'categories_list' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255|string|unique:catalog_brands',
            'description' => 'max:255',
        ]);
        $validatedData['slug'] = '/'.Str::slug($validatedData['name']);
        Brand::create($validatedData);
        return redirect()->route('backend.catalog.brands.index')->withSuccess('Marque ajoutée avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('backend.catalog.brands.form', [
            'brands' => $brand,
            'categories_list' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255|string',
            'description' => 'max:255',
        ]);
        $validatedData['slug'] = '/'.Str::slug($validatedData['name']);
        Brand::where('id', $brand->id)->update($validatedData);
        return redirect()->route('backend.catalog.brands.index')->withSuccess('Marque modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
            $brand->delete();
            return back()->withSuccess('Marque supprimée avec succès');
    }
}
