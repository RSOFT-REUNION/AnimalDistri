<?php

namespace App\Http\Controllers\Backend\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.catalog.brand.index', [
            'brands' => Brand::orderBy('id','DESC')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255|string|unique:catalog_brands',
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_description' => 'string|nullable',
            'active' => 'nullable',
        ]);
        @$validatedData['active'] = $validatedData['active'] == 'on' ? 1 : 0;
        $validatedData['slug'] = Str::slug($validatedData['name']);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $validatedData['slug'] . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/upload/catalog/brands/', $imageName);
            $validatedData['image'] = $imageName;
        }
        Brand::create($validatedData);
        return redirect()->route('backend.catalog.brands.index')->withSuccess('Marque ajoutée avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('backend.catalog.brand.edit', [ 'brand' => $brand ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $brand = Brand::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255|string|unique:catalog_brands,name,' . $brand->id,
            'image' => 'nullable',
            'short_description' => 'string|nullable',
            'active' => 'nullable',
        ]);
        @$validatedData['active'] = $validatedData['active'] == 'on' ? 1 : 0;
        $validatedData['slug'] = Str::slug($validatedData['name']);
        if ($request->hasFile('image')) {
            if ($brand->image && Storage::exists('public/upload/catalog/brands/' . $brand->image)) {
                Storage::delete('public/upload/catalog/brands/' . $brand->image);
            }
            $image = $request->file('image');
            $imageName = $validatedData['slug'] . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/upload/catalog/brands/', $imageName);
            $validatedData['image'] = $imageName;
        } else {
            // No new image uploaded, rename the existing image if necessary
            if ($brand->image) {
                $imageExtension = pathinfo($brand->image, PATHINFO_EXTENSION);
                $newImageName = $validatedData['slug'] . '.' . $imageExtension;

                // Rename the existing image file
                if ($brand->image !== $newImageName) {
                    Storage::move('public/upload/catalog/brands/' . $brand->image, 'public/upload/catalog/brands/' . $newImageName);
                    $validatedData['image'] = $newImageName;
                } else {
                    $validatedData['image'] = $brand->image;
                }
            }
        }
        $brand->update($validatedData);

        return back()->withSuccess('Marque mise à jour');
    }


    public function destroy(Brand $brand)
    {
        if ($brand->image && Storage::exists('public/upload/catalog/brands/' . $brand->image)) {
            Storage::delete('public/upload/catalog/brands/' . $brand->image);
        }
        $brand->delete();
        return back()->withSuccess('Marque supprimée avec succès');
}
}
