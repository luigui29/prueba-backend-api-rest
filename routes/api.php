<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductController;


Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show'])->whereNumber('product');
Route::get('/products/{product}/prices', [ProductController::class, 'showPrices'])->whereNumber('product');

Route::post('/products', [ProductController::class, 'store']);
Route::post('/products/{product}/prices', [ProductController::class, 'storePrices'])->whereNumber('product');

Route::put('/products/{product}', [ProductController::class, 'update'])->whereNumber('product');

Route::delete('/products/{product}', [ProductController::class, 'destroy'])->whereNumber('product');