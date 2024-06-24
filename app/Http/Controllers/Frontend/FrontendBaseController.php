<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\SymfonyResponseFactory;
use App\Http\Controllers\Controller;
use App\Models\Carts\Carts;
use App\Models\Catalog\Category;
use App\Models\Catalog\Discount;
use App\Models\Content\Carousel;
use App\Models\Content\Pages;
use App\Models\Settings\Informations;
use App\Models\Users\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureFactory;

class FrontendBaseController extends Controller
{
    public function __construct()
    {
        $infos = Informations::select('address','email','phone','fax')->where('id', 1)->first();
        $sliders = Carousel::inRandomOrder()->get();
        $menu = Pages::select('name', 'slug')->where('is_menu', 1)->where('active', 1)->get();
        $menu_produits = Category::where('category_id', 0)->orderBy('order')->with(['childrenCategories' => function ($q) {
            $q->with(['childrenCategories' => function ($q) {
                $q->orderBy('name')->orderBy('order')->where('is_menu', 1)->where('active', 1);
            }])->orderBy('name')->orderBy('order')->where('is_menu', 1)->where('active', 1);
        }])->where('is_menu', 1)->orderBy('order')->where('active', 1)->get();

        /*** Retroune un array de tout les produits en promotion avec l'offre la plus avantageuse ***/
        $discountProducts = collect();
        $discounts = Discount::currently()->with('products')->orderBy('percentage')->get();
        foreach ($discounts as $discount) {
            foreach ($discount->products as $product) {
                $discountProducts->put($product->product_id, [
                    'discountPercentage' => $discount->percentage,
                    'start_date' => $discount->start_date,
                    'end_date' => $discount->end_date,
                    'fixed_priceTTC' => $product->fixed_priceTTC,
                ]);
            }
        }
        $cities = Cities::orderBy('city')->get();
        $cart = Carts::getCartInstance();

        View::share(['infos' => $infos, 'sliders' => $sliders, 'menu' => $menu, 'menu_produits' => $menu_produits,'discounts' => $discounts, 'discountProducts' => $discountProducts->toArray(), 'cities' => $cities, 'cart' => $cart]);
    }

    public function images_show(Request $request, string $path)
    {
        SignatureFactory::create(config('laravel-glide.key'))->validateRequest($request->path(), $request->all());
        $server = ServerFactory::create([
            'response' => new SymfonyResponseFactory($request),
            'source' => Storage::disk('public')->getDriver(),
            'cache' => Storage::disk('local')->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'images',
        ]);
        return $server->getImageResponse($path, $request->all());
    }
}
