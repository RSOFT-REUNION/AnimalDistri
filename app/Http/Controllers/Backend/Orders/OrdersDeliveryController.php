<?php

namespace App\Http\Controllers\Backend\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrdersDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.orders.delivery.index', [
            'delivery' => Delivery::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deliver = new Delivery();
        return view('backend.orders.delivery.form', [
            'deliver' => $deliver,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:order_delivery|max:255',
            'description' => 'string|max:255|nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price_ttc' => 'required|integer|nullable',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active'] == 'on' ? 1 : 0;
        if ($request->hasFile('image')) {
            $imageName = Str::slug($validated['image']->getClientOriginalName(), '.');
            $validated['image']->storeAs('public/upload/order/delivery', $imageName);
            $validated['image'] = $imageName;
        }
        Delivery::create($validated);
        return redirect()->route('backend.orders.delivery.index')->withSuccess('Option de livraison ajouté avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        return view('backend.orders.delivery.form', [
            'deliver' => $delivery,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255|nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price_ttc' => 'required|integer|nullable',
            'active' => '',
        ]);
        @$validated['active'] = $validated['active'] == 'on' ? 1 : 0;
        if (@$validated['image']) {
            /*** Suppresion de l'ancienne image ***/
            $old = Delivery::select('image')->where('id', $delivery->id)->first();
            Storage::delete('public/upload/order/delivery/' . $old->image);
            /*** ***/
            $imageName = Str::slug($validated['image']->getClientOriginalName(), '.');
            $validated['image']->storeAs('public/upload/order/delivery/', $imageName);
            $validated['image'] = $imageName;
            Delivery::where('id', $delivery->id)->update($validated);
            return back()->withSuccess('Option de livraison modifié avec succès');
        } else {
            Delivery::where('id', $delivery->id)->update($validated);
            return back()->withSuccess('Option de livraison modifié avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        Storage::delete('public/upload/order/delivery/' . $delivery->image);
        $delivery->delete();
        return back()->withSuccess('Option de livraison supprimé avec succès');
    }
}
