<?php


use App\Http\Controllers\Backend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Backend\Auth\NewPasswordController;
use App\Http\Controllers\Backend\Auth\PasswordController;
use App\Http\Controllers\Backend\Auth\PasswordResetLinkController;
use App\Http\Controllers\Backend\ProfileController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::middleware('guest:admin')->group(function () {

    Route::get('admin/login', [AuthenticatedSessionController::class, 'create'])
        ->name('backend.login');

    Route::post('admin/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('admin/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('backend.password.request');

    Route::post('admin/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('backend.password.email');

    Route::get('admin/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('backend.password.reset');

    Route::post('admin/reset-password', [NewPasswordController::class, 'store'])
        ->name('backend.password.store');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('admin/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('backend.password.confirm');

    Route::post('admin/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('admin/password', [PasswordController::class, 'update'])->name('backend.password.update');

    Route::post('admin/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('backend.logout');

    Route::prefix('admin/profile')->name('backend.profile.')->controller(ProfileController::class)->group(function (){
       Route::get('/', 'edit')->name('edit');
       Route::post('/update', 'update')->name('update');
       Route::post('/updatepassword', 'updatepassword')->name('updatepassword');
    });
});
