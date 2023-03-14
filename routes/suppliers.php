<?php

use App\Http\Controllers\Api\V1\SupplierController;
use Illuminate\Support\Facades\Route;

Route::GET('', [SupplierController::class, 'index'])->name('suppliers.index');
Route::POST('', [SupplierController::class, 'create'])->name('suppliers.create');
Route::GET('{supplierUUID}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::DELETE('{supplierUUID}', [SupplierController::class, 'delete'])->name('suppliers.delete');
Route::post('store', [SupplierController::class, 'store'])->name('suppliers.store');
Route::PUT('{supplierUUID}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::GET('{supplierUUID}/addresses', [SupplierController::class, 'getAddresses'])->name('suppliers.addresses');
Route::GET('{supplierUUID}/contacts', [SupplierController::class, 'getContacts'])->name('suppliers.contacts');
