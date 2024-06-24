<?php

namespace App\Http\Controllers\Backend\Catalog;

use App\Http\Controllers\Controller;
use App\Imports\CatalogDiscountImport;
use App\Imports\CatalogDiscountProductsImport;
use App\Models\Catalog\Discount;
use App\Models\Catalog\DiscountProduct;
use App\Models\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.catalog.discount.index', [
            'discounts' => Discount::orderBy('id','DESC')->get(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $discount = new Discount();
        return view('backend.catalog.discount.form', [
            'discount' => $discount,
        ]);
    }

    /**
     * Create and store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|min:3|max:255|required',
            'percentage' => 'integer|min:1|max:100|required',
            //'icon' => 'in:star,heart,bolt,gift,snowflake,grill-hot,fish,leaf,award,head-side,meat,sparkles,bookmark,circle-euro,mug-tea,watermelon-slice,tree-palm,user-tie|required',
            'start_date' => 'date|required|after_or_equal:yesterday',
            'end_date' => 'date|required|after_or_equal:start_date',
            'short_description' => 'string|max:255|nullable',
            'active' => 'nullable',
        ]);
        @$validated['active'] = $validated['active'] == 'on' ? 1 : 0;
        $discount = Discount::create($validated);
        return to_route('backend.catalog.discounts.edit', $discount)->withSuccess('Promotion ajoutée avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        return view('backend.catalog.discount.form', [
            'discount' =>   $discount,
            'products_list' => Product::orderBy('id', 'DESC')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'string|min:3|max:255|required',
            'percentage' => 'integer|min:1|max:100|required',
            //'icon' => 'in:star,heart,bolt,gift,snowflake,grill-hot,fish,leaf,award,head-side,meat,sparkles,bookmark,circle-euro,mug-tea,watermelon-slice,tree-palm,user-tie|required',
            'start_date' => 'date|required',
            'end_date' => 'date|required|after_or_equal:start_date',
            'short_description' => 'string|max:255|nullable',
            'active' => 'nullable',
        ]);
        @$validated['active'] = $validated['active'] == 'on' ? 1 : 0;
        $discount->update($validated);
        return redirect()->route('backend.catalog.discounts.edit', [
            'discount' => $discount,
        ])->withSuccess('Promotion modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return back()->withSuccess('Promotion supprimée');
    }


    public function add_products(Request $request, Discount $discount)
    {
         $validated = $request->validate([
                'discount_products' => 'array|nullable'
         ]);
        foreach ($validated['discount_products'] as $product) {
            $product = json_decode($product, true);
            DiscountProduct::create([
                'discount_id' => $discount->id,
                'product_id' => $product['id'],
            ]);
        }
        return redirect()->route('backend.catalog.discounts.edit', [
            'discount' =>   $discount,
            'products_list' => Product::orderBy('id', 'DESC')->get(),
        ])->withSuccess('Produits ajoutée avec succès');
    }

    public function destroy_product(Request $request,Discount $discount, DiscountProduct $product)
    {
        $product->delete();
        return redirect()->route('backend.catalog.discounts.edit', [
            'discount' =>   Discount::with('products')->findOrFail($discount->id),
            'products_list' => Product::orderBy('id', 'DESC')->get(),
        ])->withSuccess('Produits supprimer avec succès');
    }

    public function force_priceTTC(DiscountProduct $product)
    {
        return view('backend.catalog.discount.partial.force_pricettc_form', [
            'product' => $product,
        ]);
    }
    public function update_force_priceTTC(Request $request,Discount $discount, DiscountProduct $product)
    {
        $product->fixed_priceTTC = $request->fixed_priceTTC * 100;
        if ($request->fixed_priceTTC == 0) $product->fixed_priceTTC = null;
        $product->save();
        return to_route('backend.catalog.discounts.edit', $discount);
    }

    public function import(Request $request)
    {
        Excel::import(new CatalogDiscountImport(), $request->discount_list, $request->discount_list);
        Excel::import(new CatalogDiscountProductsImport(), $request->discount_products, $request->discount_products);
        return back()->withSuccess('Promotion importer avec succès');
    }

}
