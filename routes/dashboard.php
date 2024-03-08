<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['auth:admin',],
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard',
], function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);/*
 if I Want Name the Route Non Of Default Name I use :
->names([
    'index'=>'dashboard.category.index'
    'create'=>'dashboard.category.index'
    'store'=>'dashboard.category.index'
    'show'=>'dashboard.category.index'
    'edit'=>'dashboard.category.index'
    'update'=>'dashboard.category.index'
    'destroy'=>'dashboard.category.index'
])

*/
});
