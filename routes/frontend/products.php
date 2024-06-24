<?php

use App\Http\Controllers\Frontend\Catalog\ProductController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::get('/nos-produits', [ProductController::class, 'first_category_list'])->name('product.first_category_list');
Route::get('/nos-produits/{slug}', [ProductController::class, 'category_list'])->name('product.list')->where(['slug' => $slugRegex]);
Route::get('/produit/{slug}.html', [ProductController::class, 'product_show'])->name('product.show')->where(['slug' => $slugRegex]);
