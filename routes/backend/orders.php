<?php

use App\Http\Controllers\Backend\Orders\OrdersController;
use App\Http\Controllers\Backend\Orders\OrdersDeliveryController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::prefix('admin/commandes')->name('backend.orders.')->middleware('auth:admin')->group(function () use ($idRegex, $slugRegex) {
    Route::group(['middleware' => ['permission:orders.orders.create|orders.orders.update|orders.orders.delete']], function () {
        Route::resource('orders', OrdersController::class);
        Route::get('/details/{order}', [OrdersController::class, 'details'])->name('detail');
        Route::post('/orders/{order}/updateStatus', [OrdersController::class, 'updateStatus'])->name('updateStatus');
    });
  //  Route::group(['middleware' => ['permission:orders.invoices.create|orders.invoices.update|orders.invoices.delete']], function () {
  //      Route::resource('invoices', InvoicesController::class)->except(['show']);
  //  });
    Route::group(['middleware' => ['permission:orders.delivery.create|orders.delivery.update|orders.delivery.delete']], function () {
        Route::resource('delivery', OrdersDeliveryController::class)->except(['show']);
    });
});


