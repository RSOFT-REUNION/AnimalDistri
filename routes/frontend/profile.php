<?php

use App\Http\Controllers\Frontend\Users\AddressesController;
use App\Http\Controllers\Frontend\Users\ProfileController;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::middleware(['auth'])->group(function ()  use ($idRegex, $slugRegex) {
    Route::get('/mon-compte', [ProfileController::class, 'index'] )->name('dashboard');
    //Informations
    Route::get('/mon-compte/mes-informations', [ProfileController::class, 'info_edit'])->name('info.edit');
    Route::patch('/mon-compte/mes-informations', [ProfileController::class, 'info_update'])->name('info.update');
    Route::put('/mon-compte/mes-informations/newsletter', [ProfileController::class, 'info_newsletter'])->name('info.newsletter');

    //Orders
    Route::get('/mon-compte/mes-commandes', [ProfileController::class, 'orders_show'])->name('orders.show');
    //address
    Route::resource('/mon-compte/mes-adresses', AddressesController::class)->except(['show'])->names([
        'index' => 'address.index',
        'store' => 'address.store',
        'create' => 'address.create',
        'update' => 'address.update',
        'destroy' => 'address.destroy',
        'edit' => 'address.edit',
    ]);
    Route::put('/mon-compte/mes-adresses/fav/{address}', [AddressesController::class, 'fav_address'])->name('address.fav_address')->where(['address' => $idRegex]);

});
