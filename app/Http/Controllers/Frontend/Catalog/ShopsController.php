<?php

namespace App\Http\Controllers\Frontend\Catalog;


use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Models\Catalog\Shop;

class ShopsController extends FrontendBaseController
{
    public function index()
    {
        return view('frontend.specific.shops.index', [
            'shops' => Shop::where('active', 1)->get(),
        ]);
    }
}
