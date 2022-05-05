<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\ClientController;
// use App\Http\Controllers\ItemController;
// use App\Http\Controllers\OrderController;
// use App\Http\Controllers\TableController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('ro')->group(function () {
    Route::apiResource('client', 'ClientController');
    Route::apiResource('item', 'ItemController');
    Route::apiResource('order', 'OrderController');
    Route::apiResource('table', 'TableController');
    
});
