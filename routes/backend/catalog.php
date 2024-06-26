<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Catalog\ProductController;
use App\Http\Controllers\Backend\Catalog\CategoryController;
use App\Http\Controllers\Backend\Catalog\BrandController;
use App\Http\Controllers\Backend\Catalog\ShopsController;
use App\Http\Controllers\Backend\Catalog\DiscountController;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::prefix('admin/catalogue')->name('backend.catalog.')->middleware('auth:admin')->group(function () use ($idRegex, $slugRegex) {
    Route::group(['middleware' => ['permission:catalog.products.create|catalog.products.update|catalog.products.delete']], function () use ($idRegex) {
        Route::resource('products', ProductController::class)->except(['show']);
        Route::get('products/listimages/{product}', [ProductController::class, 'list_image'])->name('products.list_image');
        Route::post('products/addimages/{product}', [ProductController::class, 'add_image'])->name('products.add_image')->where(['product' => $idRegex]);
        Route::delete('products/images/{image}', [ProductController::class, 'destroy_image'])->name('products.destroy_image')->where(['image' => $idRegex]);
        Route::put('products/images/{image}', [ProductController::class, 'fav_image'])->name('products.fav_image')->where(['image' => $idRegex]);
        Route::post('products/import', [ProductController::class, 'import'])->name('products.import')->where(['product' => $idRegex]);
    });
    Route::group(['middleware' => ['permission:catalog.categories.create|catalog.categories.update|catalog.categories.delete']], function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::post('categories/import', [CategoryController::class, 'import'])->name('categories.import');
        Route::post('categories/order', [CategoryController::class, 'updateOrder'])->name('categories.order');
    });
    Route::group(['middleware' => ['permission:catalog.brands.create|catalog.brands.update|catalog.brands.delete']], function () {
        Route::resource('brands', BrandController::class)->except(['show']);
    });
    Route::group(['middleware' => ['permission:catalog.shops.create|catalog.shops.update|catalog.shops.delete']], function () {
        Route::resource('shops', ShopsController::class)->except(['show']);
    });
    Route::group(['middleware' => ['permission:catalog.discounts.create|catalog.discounts.update|catalog.discounts.delete']], function () use ($idRegex) {
        Route::resource('discounts', DiscountController::class)->except(['show']);
        Route::post('discounts/addproducts/{discount}', [DiscountController::class, 'add_products'])->name('discounts.add_products')->where(['discount' => $idRegex]);
        Route::post('discounts/products/destroy_product/{discount}-{product}', [DiscountController::class, 'destroy_product'])->name('discounts.destroy_product');
        Route::post('discounts/products/update_force_priceTTC/{discount}-{product}', [DiscountController::class, 'update_force_priceTTC'])->name('discounts.update_force_priceTTC');
        Route::post('discounts/import', [DiscountController::class, 'import'])->name('discounts.import');
    });
});
