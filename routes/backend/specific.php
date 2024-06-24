<?php

use App\Http\Controllers\Backend\Specific\AnimationsController;
use App\Http\Controllers\Backend\Specific\LabelsController;
use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

Route::prefix('admin/specifique')->name('backend.specific.')->middleware('auth:admin')->group(function () use ($idRegex) {

});
