<?php

use App\Http\Controllers\Api\V1\CustomerController;
use Illuminate\Support\Facades\Route;

Route::POST('', [CustomerController::class, 'create'])->name('customer.create');
Route::GET('', [CustomerController::class, 'index'])->name('customers.index');
Route::GET('{customerUUID}', [CustomerController::class, 'show'])->name('customer.show');
Route::DELETE('{customerUUID}', [CustomerController::class, 'delete'])->name('customers.delete');
Route::POST('customerUUID', [CustomerController::class, 'store'])->name('customer.store');
Route::PUT('{customerUUID}', [CustomerController::class, 'update'])->name('customer.update');
Route::GET('{customerUUID}/addresses', [CustomerController::class, 'getAddresses'])->name('customers.addresses');
Route::GET('{customerUUID}/contacts', [CustomerController::class, 'getContacts'])->name('customers.contacts');
