<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Catalog\Discount;
use App\Models\Catalog\Product;
use App\Models\Content\Pages;
use App\Models\Settings\Informations;
use App\Models\Specific\Labels;
use Illuminate\Http\Request;

class FrontController extends FrontendBaseController
{
    public function index()
    {
        $pages = Pages::where('id', '=', '1')->first();
        $products_random = Product::with('images')->where('active',1)->inRandomOrder()->limit(6)->get();
        return view('frontend.index', [
            'page' => $pages,
            'products_random' => $products_random,
        ]);
    }
    public function legalnotice()
    {
        $legalnotice = Informations::select('legalnotice')->where('id', '=', '1')->first();
        return view('frontend.pages.legalnotice', [
            'legalnotice' => $legalnotice,
        ]);
    }
    public function termsofservice()
    {
        $termsofservice = Informations::select('termsofservice')->where('id', '=', '1')->first();
        return view('frontend.pages.termsofservice', [
            'termsofservice' => $termsofservice,
        ]);
    }
    public function contact()
    {
        return view('frontend.pages.contact');
    }


    /*** Recherche ***/
    public function search(Request $request)
    {
        $products = Product::query()->with('images')
            ->where('active', 1)
            ->where('name', 'LIKE', "%{$request->input('search')}%")
            ->orWhere('erp_id', 'LIKE', "%{$request->input('search')}%")
            ->paginate(8);
        return view('frontend.pages.search', [
            'search' => $request->search,
            'products' => $products,
        ]);
    }

    /*** Gestion des pages ***/
    public function pages(string $slug, Pages $pages)
    {
        $pages = $pages->where('slug', '=', '/'.$slug)->where('active', 1)->first();
        if($pages) {
            return view('frontend.pages.show', [
                'page' => $pages,
            ]);
        } else {
            return view('frontend.errors.404', [
                'page' => '',
            ]);
        }
    }
}
