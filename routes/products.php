<?php

use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductVarientController;
use Illuminate\Support\Facades\Route;

Route::get('/variant', [ProductVarientController::class, 'index'])->name('product-variant.index');
Route::POST('/variant', [ProductVarientController::class, 'store'])->name('product-variant.store');
Route::PUT('/variant/{id}', [ProductVarientController::class, 'update'])->name('product-variant.store');

//product
Route::GET('/', [ProductController::class, 'index'])->name('products.index');
Route::GET('/{uuid}', [ProductController::class, 'show'])->name('products.show');
Route::GET('/search/{text}', [ProductController::class, 'searchBytext'])->name('products.search');
