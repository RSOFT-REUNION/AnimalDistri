<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Content\Carousel;
use App\Models\Content\Category;
use App\Models\Content\Pages;
use App\Models\Settings\Teams\Administrator;
use Spatie\Permission\Traits\HasRoles;


class DashboardController extends Controller
{
    use HasRoles;

    public function index (Administrator $user) {
        return view('backend.dashboard', [
            'pages' => Pages::count()+2,
            'category' => Category::count(),
            'carousel' => Carousel::count(),
        ]);
    }
}
