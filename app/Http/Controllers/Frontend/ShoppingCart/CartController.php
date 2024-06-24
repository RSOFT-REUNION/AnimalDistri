<?php

namespace App\Http\Controllers\Frontend\ShoppingCart;

use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Models\Carts\Carts;
use App\Models\Carts\CartsProducts;
use App\Models\Catalog\Discount;
use App\Models\Catalog\Product;
use App\Models\Orders\Delivery;
use App\Models\Users\Address;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mauricius\LaravelHtmx\Http\HtmxResponseClientRefresh;

class CartController extends FrontendBaseController
{
    public function index()
    {
        $this->update_cart_product();
        $cart = Carts::getCartInstance();
        return view('frontend.carts.index', compact('cart'));
    }

    public function select_slot(Request $request, Product $product)
    {
        return view('frontend.carts.partials.select_slot_modal_content', [
            'product' => $product,
            'chosed_cities' => $request->chosed_cities,
        ]);
    }

    public function chose_address()
    {
        if (!Auth::check()) {
            return redirect()->route('login', ['page' => 'cart']);
        }

        $cart = Carts::getCartInstance();
        $address = Address::where('user_id', Auth::id())->get();

        return view('frontend.carts.chose_address', compact('cart', 'address'));
    }

    public function create_address(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'address2' => 'max:255',
            'other' => 'max:255',
            'cities' => 'required',
            'country' => 'nullable',
            'phone' => 'required|string|max:20',
            'other_phone' => 'max:20',
            'favorite' => '',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['alias'] = "Mon adresse";
        $validated['country'] = "La Réunion";

        $user_address = Address::create($validated);
        $user_address->favorite = $user_address->id;
        $user_address->save();

        return $user_address;
    }

    public function chose_delivery(Request $request)
    {
        $user_address = $request->add_address ? $this->create_address($request) : Address::findOrFail($request->address);

        return view('frontend.carts.chose_delivery', [
            'user_address' => $user_address,
            'user_address_fac' => Address::where('user_id', Auth::id())->whereNotNull('favorite')->first(),
            'cart' => Carts::with('product')->findOrFail($request->cart),
            'delivery' => Delivery::where('active', 1)->get(),
        ]);
    }

    public function chosed_delivery(Request $request)
    {
        return view('frontend.carts.partials.delivery_index', [
            'user_address' => Address::findOrFail($request->address),
            'user_address_fac' => Address::where('user_id', Auth::id())->whereNotNull('favorite')->first(),
            'cart' => Carts::with('product')->findOrFail($request->cart),
            'delivery' => Delivery::where('active', 1)->get(),
            'delivery_chose' => Delivery::findOrFail($request->deliver),
            'loyality' => User::select('erp_id', 'erp_loyalty_points', 'erp_loyalty_card')->findOrFail(Auth::id()),
        ]);
    }

    public function chosed_delivery_date(Request $request, string $delivery, string $delivery_date, string $delivery_slot)
    {
        return view('frontend.carts.partials.delivery_index', [
            'user_address' => Address::findOrFail($request->address),
            'user_address_fac' => Address::where('user_id', Auth::id())->whereNotNull('favorite')->first(),
            'cart' => Carts::with('product')->findOrFail($request->cart),
            'delivery' => Delivery::where('active', 1)->get(),
            'delivery_chose' => Delivery::findOrFail($request->deliver),
            'delivery_date' => $delivery_date,
            'delivery_slot' => $delivery_slot,
            'loyality' => User::select('erp_id', 'erp_loyalty_points', 'erp_loyalty_card')->findOrFail(Auth::id()),
        ]);
    }

    public function cart_summary(Request $request)
    {
        $deliver = Delivery::findOrFail($request->delivery);
        $cart = Carts::getCartInstance();
        $cart->loyality = $request->loyality;
        $cart->delivery_id = $request->delivery;
        $cart->delivery_price = $deliver->price_ttc;
        $cart->delivery_date = $request->delivery_date;
        $cart->delivery_slot = $request->delivery_slot;
        $cart->total_ttc  = $cart->countProductsPrice($deliver->price_ttc, $request->loyality);
        $cart->save();
        return view('frontend.carts.summary', [
            'user_address' => Address::findOrFail($request->address),
            'user_address_fac' => Address::where('user_id', Auth::id())->whereNotNull('favorite')->first(),
            'cart' => $cart,
            'deliver' => $deliver,
            'error_message' => null,
        ]);
    }

    public function update_cart_product()
    {
        $cart = Carts::getCartInstance();
        foreach ($cart->product as $product) {
            $productinfo = Product::firstwhere('id', $product->product_id);
            $discountProducts = collect();
            $discounts = Discount::currently()->with('products')->orderBy('percentage')->get();
            foreach ($discounts as $discount) {
                foreach ($discount->products as $productdiscount) {
                    $discountProducts->put($productdiscount->product_id, $discount);
                }
            }
            if ($discountProducts->has($product->product_id)) {
                $product->discount_id = $discountProducts->get($product->product_id)->id;
                $product->discount_percentage = $discountProducts->get($product->product_id)->percentage;
                foreach ($discountProducts->get($product->product_id)->products as $productdiscount) {
                    if ($productdiscount->product_id == $product->product_id) {
                        $product->discount_fixed_price_ttc = $productdiscount->fixed_priceTTC;
                    }
                }
            } else {
                $product->discount_id = null;
                $product->discount_percentage = null;
                $product->discount_fixed_price_ttc = null;
            }
            $product->price_ht = $productinfo->price_ht;
            $product->tva = $productinfo->tva;
            $product->price_ttc = $productinfo->price_ttc;
            $product->stock_unit = $productinfo->stock_unit;
            $product->save();
        }
    }

    public function add_product(Request $request, Product $produit)
    {
        $cart = Carts::getCartInstance();
        $existingProduct = $cart->product()->where('product_id', $produit->id)->first();
        $product_stock = Product::select('stock')->firstwhere('id', $produit->id);
        if ($existingProduct) {
            if ($existingProduct->stock_unit == 'kg') {
                if($existingProduct->quantity < $product_stock->stock) {
                    $existingProduct->quantity = $request->quantity ? $request->quantity : $existingProduct->quantity + 100;
                }
            } else {
                if($existingProduct->quantity < $product_stock->stock / 1000) {
                    $existingProduct->quantity = $request->quantity ? $request->quantity : $existingProduct->quantity + 1;
                }
            }
            $existingProduct->save();
        } else {
            if ($produit->stock_unit == 'kg') {
                $proquantity = $request->quantity ?: 100;
            } else {
                $proquantity = $request->quantity ?: 1;
            }
            // Retrieve discount products
            $discountProducts = collect();
            $discounts = Discount::currently()->with('products')->orderBy('percentage')->get();
            foreach ($discounts as $discount) {
                foreach ($discount->products as $product) {
                    $discountProducts->put($product->product_id, $discount);
                }
            }
            // Create a new cart product entry
            $cartProductData = [
                'fav_image' => $produit->getFirstImagesURL(),
                'product_id' => $produit->id,
                'price_ht' => $produit->price_ht,
                'tva' => $produit->tva,
                'price_ttc' => $produit->price_ttc,
                'stock_unit' => $produit->stock_unit,
                'quantity' => $proquantity,
            ];

            if ($discountProducts->has($produit->id)) {
                $cartProductData['discount_id'] = $discountProducts->get($produit->id)->id;
                $cartProductData['discount_percentage'] = $discountProducts->get($produit->id)->percentage;
                foreach ($discountProducts->get($produit->id)->products as $product) {
                    if ($product->product_id == $produit->id) {
                        $cartProductData['discount_fixed_price_ttc'] = $product->fixed_priceTTC;
                    }
                }
            }  else {
                $cartProductData['discount_id'] = null;
                $cartProductData['discount_percentage'] = null;
                $cartProductData['discount_fixed_price_ttc'] = null;
            }
            $cart->product()->create($cartProductData);
        }

        return view('frontend.layouts.partials.cart_modal', [
            'cart' => $cart,
        ]);

    }

    public static function count_product()
    {
        $cookie = request()->cookie('session_id');
        if (Auth::check()) {
            $cart = Carts::where('user_id', Auth::id())->where('status', 'En cours')->first();
            if ($cart) {
                cookie()->queue(cookie()->forever('session_id', $cart->session_id));
                $cookie = $cart->session_id;
            }
        }

        $cart = Carts::where('session_id', $cookie)->first();
        if (!$cart) {
            return 0;
        }

        $count = 0;
        foreach ($cart->product as $product) {
            if ($product->stock_unit == 'kg') {
                $count = $count + 1;
            } else {
                $count = $count + $product->quantity;
            }
        }
        return $count;
    }

    public static function count_product_json()
    {
        $cookie = request()->cookie('session_id');
        if (Auth::check()) {
            $cart = Carts::where('user_id', Auth::id())->where('status', 'En cours')->first();
            if ($cart) {
                cookie()->queue(cookie()->forever('session_id', $cart->session_id));
                $cookie = $cart->session_id;
            }
        }

        $cart = Carts::where('session_id', $cookie)->first();
        if (!$cart) {
            return 0;
        }

        $count = 0;
        foreach ($cart->product as $product) {
            if ($product->stock_unit == 'kg') {
                $count = $count + 1;
            } else {
                $count = $count + $product->quantity;
            }
        }
        return response()->json(['count' => $count]);
    }

    public function update_quantity_product(Request $request, $product)
    {
        $product = CartsProducts::findOrFail($product);
        $product->quantity = $request->quantity;
        $product->save();
        return new HtmxResponseClientRefresh();
    }

    public function delete_product(CartsProducts $produit)
    {
        $produit->delete();
        return back()->withsuccess('Le produit a bien été retiré au panier.');
    }
}
