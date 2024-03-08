<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\DeliveriesController;
use App\Http\Controllers\Api\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('products', ProductController::class);
Route::post('auth/access-tokens', [AccessTokensController::class, 'store'])->middleware('guest:sanctum');
Route::put('deliveries/{delivery}', [DeliveriesController::class, 'update']);
Route::get('deliveries/{delivery}', [DeliveriesController::class, 'show']);
