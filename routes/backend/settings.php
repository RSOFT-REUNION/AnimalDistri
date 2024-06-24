<?php
use App\Http\Controllers\Backend\Settings\Information;
use App\Http\Controllers\Backend\Settings\Teams\AdministratorsController;
use App\Http\Controllers\Backend\Settings\Teams\RolesController;
use Illuminate\Support\Facades\Route;
$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::prefix('admin/parametres')->name('backend.settings.')->middleware('auth:admin')->group(function () use ($idRegex) {
    Route::prefix('/equipes')->name('teams.')->group(function () use ($idRegex) {
        Route::group(['middleware' => ['permission:settings.teams.roles.create|settings.teams.roles.update|settings.teams.roles.delete|permission:settings.teams.administrators.create|settings.teams.administrators.update|settings.teams.administrators.delete|settings.teams.administrators.changepassword']], function () {
            Route::get('/', function () { return view('backend.settings.teams.index');})->name('index');
            Route::group(['middleware' => ['permission:settings.teams.roles.create|settings.teams.roles.update|settings.teams.roles.delete']], function () {
                Route::resource('roles', RolesController::class)->except(['show']);
            });
            Route::group(['middleware' => ['permission:permission:settings.teams.administrators.create|settings.teams.administrators.update|settings.teams.administrators.delete|settings.teams.administrators.changepassword']], function () {
                Route::resource('administrators', AdministratorsController::class)->except(['show']);
                Route::put('administrators/{administrator}/changepassword', [AdministratorsController::class, 'changeMDP'])->name('administrators.changepassword');
            });
        });
    });
    Route::group(['middleware' => ['permission:settings.information.update']], function () {
        Route::get('informations', [Information::class, 'index'])->name('informations.index');
        Route::post('informations', [Information::class, 'update'])->name('informations.update');
        Route::get('mentions-legales', [Information::class, 'legalnoticeindex'])->name('legalnotice.index');
        Route::post('mentions-legales', [Information::class, 'legalnoticeupdate'])->name('legalnotice.update');
        Route::get('conditions-generales-dutilisation', [Information::class, 'termsofserviceindex'])->name('termsofservice.index');
        Route::post('conditions-generales-dutilisation', [Information::class, 'termsofserviceupdate'])->name('termsofservice.update');
    });
});
