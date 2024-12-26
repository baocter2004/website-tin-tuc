<?php

use App\Http\Controllers\Client\API\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(ClientController::class)
// middleware('auth:sanctum')
    ->name('client.')
    ->group(function () {
        Route::get('/','index')->name('index');
    });
