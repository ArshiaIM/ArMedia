<?php

use Illuminate\Support\Facades\Route;
use Modules\ArMedia\Http\Controllers\ArMediaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('armedia', ArMediaController::class)->names('armedia');
    Route::get('/armedia/items', [ArmediaController::class, 'getItems'])->name('armedia.getItems');
});
