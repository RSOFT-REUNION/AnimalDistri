<?php
use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;
$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

/*** Login ***/
Route::get('/admin', [DashboardController::class, 'index'])->middleware(['auth:admin', 'verified'])->name('backend.dashboard');
require __DIR__ . '/auth.php';
require __DIR__ . '/content.php';
require __DIR__ . '/orders.php';
require __DIR__ . '/catalog.php';
require __DIR__ . '/clients.php';
require __DIR__ . '/specific.php';
require __DIR__ . '/settings.php';

/*** Upload image depuis SummerNote ***/
Route::post('/', function () {
    if (request()->has('image')) {
        $file = request()->file('image');
        $name = $file->getClientOriginalName();
        $file->move(public_path('storage/upload/pages/'), $name);
        return asset('storage/upload/pages/' . $name);
    }
});
