<?php

use App\Http\Controllers\Backend\Clients\ClientsController;
use App\Http\Controllers\Backend\Clients\ClientsGroupsController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::prefix('admin/clients')->name('backend.clients.')->middleware('auth:admin')->group(function () use ($idRegex, $slugRegex) {
        Route::group(['middleware' => ['permission:clients.client.show']], function () {
            Route::resource('client', ClientsController::class)->except(['show']);
            Route::get('/adresses/{client}', [ClientsController::class, 'addresses'])->name('adresse');
            Route::post('import', [ClientsController::class, 'import'])->name('client.import');
        });
        Route::group(['middleware' => ['permission:clients.carts.show']], function () {
            Route::get('', [ClientsController::class, 'carts_index'])->name('carts.index');
        });
    Route::group(['middleware' => ['permission:clients.groups.create|clients.groups.update|clients.groups.delete']], function () {
        Route::resource('groups', ClientsGroupsController::class)->except(['show']);
    });
});
