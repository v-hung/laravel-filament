<?php

use App\Http\Controllers\Purchase\CartController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('{slug}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('add/{id}', [CartController::class, 'add'])->name('add');
    Route::delete('remove/{id}', [CartController::class, 'remove'])->name('remove');
});
