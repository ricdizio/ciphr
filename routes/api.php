<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'participants'], function () {
    Route::get('get', [ParticipantsController::class, "get"])->name('get');
    Route::post('create', [ParticipantsController::class, "create"])->name('create');
    Route::post('delete', [ParticipantsController::class, "delete"])->name('delete');
    Route::post('update', [ParticipantsController::class, "update"])->name('update');
});
