<?php

namespace App\Http\Controllers\Backend\Catalog;

use App\Http\Controllers\Controller;
use App\Imports\CatalogProductImport;
use App\Models\Catalog\ProductsImages;
use Illuminate\Http\Request;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.catalog.product.index', [
            'products' => Product::orderBy('id','DESC')->get(),
            'categories_list' => Category::with(['childrenCategories' => function ($q) {
                $q->orderBy('name');
            }])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|min:3|max:255|required',
            'price_ht'  => 'required',
            'tva' => 'in:0,210,850|required',
            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_categories' => 'array|nullable',
            'brand_id' => 'integer|nullable',
            'short_description' => 'string|nullable',
            'active' => 'nullable',
        ]);
        @$validatedData['active'] = $validatedData['active'] == 'on' ? 1 : 0;
        $validatedData['slug'] = Str::slug($validatedData['name']);
        $validatedData['price_ht'] = formatPriceToInteger($validatedData['price_ht']) ?? 0;
        $validatedData['price_ttc'] = $validatedData['price_ht'] * ($validatedData['tva'] / 10000) + $validatedData['price_ht'] ?? 0;
        $validatedData['created_by_id'] = auth()->id();

        $product = Product::create($validatedData);
        @$product->categories()->sync($validatedData['product_categories']);
        if ($request->hasFile('images')) {
            $product->attachImages($product->id, @$validatedData['images']);

            $product->fav_image = $product->images()?->first()->id;
            $product->save();
        }
        return back()->withSuccess('Produit ajouté');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('backend.catalog.product.edit', [
            'product' => $product,
            'product_categories' => $product->categories()->pluck('id')->all(),
            'categories_list' => Category::with(['childrenCategories' => function ($q) {
                $q->orderBy('name');
            }])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'active' => 'nullable',
            'labels' => 'nullable',
            'name' => 'string|min:3|max:255|required',
            'barcode' => 'string|nullable',
            'product_categories' => 'array|nullable',
            'brand_id' => 'integer|nullable',
            'short_description' => 'string|nullable',
            'code_article'  => 'string|nullable',
            'tags' => 'nullable',
            'composition' => 'string|nullable',
            'content' => 'string|nullable',
            'stock' => 'required',
            'stock_unit' => 'string|required',
            'weight' => 'nullable',
            'weight_unit' => 'string|nullable',
            'price_ht' => 'required',
            'tva' => 'in:0,210,850|required',
            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        @$validatedData['active'] = $validatedData['active'] == 'on' ? 1 : 0;

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $validatedData['stock'] = formatStocktoInteger($validatedData['stock']);
        @$validatedData['weight'] = formatPriceToInteger($validatedData['weight']);

        $validatedData['price_ht'] = formatPriceToInteger($validatedData['price_ht']) ?? 0;
        $validatedData['price_ttc'] = $validatedData['price_ht'] * ($validatedData['tva'] / 10000) + $validatedData['price_ht'] ?? 0;

        $validatedData['updated_by_id'] = auth()->id();

        $product->update($validatedData);
        @$product->categories()->sync($validatedData['product_categories']);
        return back()->withSuccess('Produit modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Storage::deleteDirectory('public'.$product->images_directory.$product->id);
        $product['deleted_by_id'] = auth()->id();
        $product->delete();
        return back()->withSuccess('Produit supprimé avec succès');
    }


    public function list_image(Product $product)
    {
        return view('backend.catalog.product.partial.edit_imageslist', [
            'product' => $product,
        ]);
    }
    public function add_image(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'images' => 'array',
            'images.*' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product->attachImages($product->id, @$validatedData['images']);
        return view('backend.catalog.product.partial.edit_imageslist', [
            'product' => $product
        ]);
    }

    public function destroy_image(ProductsImages $image)
    {
        $product = Product::find($image->product_id);
        if($product->fav_image == $image->id) {
            $product->fav_image = $product->images()->first()->id;
            $product->save();
        }
        Storage::delete('public'.$product->images_directory.$image->product_id.'/'.$image->name);
        $image->delete();
    }
    public function fav_image(ProductsImages $image)
    {
        $product = Product::find($image->product_id);
        $product->fav_image = $image->id;
        $product->save();
        return view('backend.catalog.product.partial.edit_imageslist', [
            'product' => $product
        ]);
    }

    public function import(Request $request)
    {
        // TODO mettre a jour l'import avec la gestion du multi catégorie
        Excel::import(new CatalogProductImport(), $request->csv);
        return back()->withSuccess('Produits importé avec succès');
    }
}
