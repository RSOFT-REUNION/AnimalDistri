<?php
use App\Http\Controllers\Backend\Content\CarouselController;
use App\Http\Controllers\Backend\Content\CategoryController;
use App\Http\Controllers\Backend\Content\PagesController;
use Illuminate\Support\Facades\Route;
$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::prefix('admin/contenu')->name('backend.content.')->middleware('auth:admin')->group(function () use ($idRegex, $slugRegex) {
    Route::group(['middleware' => ['permission:content.categories.create|content.categories.update|content.categories.delete']], function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
    });
    Route::group(['middleware' => ['permission:content.pages.create|content.pages.update|content.pages.delete']], function () {
        Route::resource('pages', PagesController::class)->except(['show']);
    });
    Route::group(['middleware' => ['permission:carousel.pages.create|content.carousel.update|content.carousel.delete']], function () {
        Route::resource('carrousel', CarouselController::class)->except(['show']);
    });
});
