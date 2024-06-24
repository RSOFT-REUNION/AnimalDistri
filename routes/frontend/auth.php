<?php

use App\Http\Controllers\Frontend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Frontend\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Frontend\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Frontend\Auth\NewPasswordController;
use App\Http\Controllers\Frontend\Auth\PasswordController;
use App\Http\Controllers\Frontend\Auth\PasswordResetLinkController;
use App\Http\Controllers\Frontend\Auth\RegisteredUserController;
use App\Http\Controllers\Frontend\Auth\VerifyEmailController;
use App\Http\Controllers\Frontend\Users\AddressesController;
use App\Http\Controllers\Frontend\Users\ProfileController;
use Illuminate\Support\Facades\Route;
$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';


Route::middleware('guest')->group(function () {
    Route::get('creer-un-compte', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('creer-un-compte', [RegisteredUserController::class, 'store']);

    Route::get('connexion', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('connexion', [AuthenticatedSessionController::class, 'store']);

    Route::get('mot-de-passe-oublie', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('mot-de-passe-oublie', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reinitialiser-le-mot-de-passe/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reinitialiser-le-mot-de-passe', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('verification-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verification-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
Route::middleware(['auth', 'verified'])->group(function ()  use ($idRegex, $slugRegex) {
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});
