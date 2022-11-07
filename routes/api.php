<?php

use App\Http\Controllers\api\CryptosController;
use App\Http\Controllers\api\CurrenciesController;
use App\Http\Controllers\api\PricesController;
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

Route::prefix('cryptos')->controller(CryptosController::class)->group(function() {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});

Route::prefix('currencies')->controller(CurrenciesController::class)->group(function() {
    Route::get('/', 'index');
});

Route::prefix('prices')->controller(PricesController::class)->group(function() {
    Route::get('/current/{id}', 'current');
    Route::get('/{id}', 'show');
    Route::post('/{id}', 'showByDatetime');
});
