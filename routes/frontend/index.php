<?php
use App\Http\Controllers\Frontend\FrontController;
use App\Http\Controllers\Frontend\FrontendBaseController;
use Illuminate\Support\Facades\Route;
$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/products.php';
require __DIR__ . '/shopping_cart.php';
require __DIR__ . '/orders.php';
require __DIR__ . '/specific.php';

/*** Home ***/
Route::get('/', [FrontController::class, 'index'] )->name('index');

/*** Recherche ***/
Route::get('/recherche', [FrontController::class, 'search'] )->name('search');

if (Route::current() != '/admin') {
    Route::get('/mentions-legales', [FrontController::class, 'legalnotice'])->name('legalnotice');
    Route::get('/conditions-generales-d-utilisation', [FrontController::class, 'termsofservice'])->name('termsofservice');
    Route::get('/contactez-nous', [FrontController::class, 'contact'])->name('contact');
    Route::get('{slug}', [FrontController::class, 'pages'])->name('pages')->where(['slug' => $slugRegex]);
}

Route::get('/images/{path}', [FrontendBaseController::class, 'images_show'])->where('path', '.*');
