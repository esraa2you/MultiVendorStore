<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\OrdersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------888
| Web Routes888
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}/show', [ProductsController::class, 'show'])->name('products.show');
Route::resource('carts', CartController::class);
Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);
Route::get('auth/user/2fa', [TwoFactorAuthenticationController::class, 'index'])->name('front.2fa');
//require __DIR__ . '/auth.php';

require __DIR__ . '/dashboard.php';



Route::get('map', [OrdersController::class, 'show']);
