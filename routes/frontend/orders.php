<?php

use App\Http\Controllers\Frontend\Orders\OrdersController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::post('/cart_validation', [OrdersController::class, 'cart_validation'])->name('orders.cart_validation');
Route::post('/send_payment', [OrdersController::class, 'sendPaymentRequest'])->name('orders.send_payment');
Route::post('/return_payment', [OrdersController::class, 'getPaymentReturn'])->name('orders.return_payment');
Route::get('/return_payment/failed', [OrdersController::class, 'paymentFailedOrAbandonned'])->name('orders.failed');
Route::get('/return_payment/success', [OrdersController::class, 'orderValidated'])->name('orders.success');

