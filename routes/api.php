<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegistrationController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\GlobalAddressController;
use App\Http\Controllers\Api\V1\PurchaseController;
use App\Http\Controllers\Api\V1\SaleController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\SuppliersController;
use App\Http\Controllers\Api\V1\UserController;
use App\Models\Accounts;
use App\Models\Address;
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

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout.api');

    Route::group(['prefix' => 'v1'], function () {
        //account
        Route::POST('account/create', [AccountController::class, 'updateOrCreate'])->name('account.create');
        Route::GET('accounts', [AccountController::class, 'accounts'])->name('accounts');

        //user
        //Route::POST('user/create', [UserController::class,'updateOrCreate'])->name('user.create');
        Route::POST('user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::GET('users', [UserController::class, 'users'])->name('users');
        Route::GET('user/{id}', [UserController::class, 'user'])->name('user');

        //supplier
        Route::POST('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::GET('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::GET('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
        Route::DELETE('suppliers/{supplier}', [SupplierController::class, 'delete'])->name('suppliers.delete');
        Route::POST('suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::PUT('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::GET('suppliers/{supplier}/addresses', [SupplierController::class, 'getAddresses'])->name('suppliers.addresses');
        Route::GET('suppliers/{supplier}/contacts', [SupplierController::class, 'getContacts'])->name('suppliers.contacts');
        //customer
        Route::POST('customers/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::GET('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::GET('customers/{customer}', [CustomerController::class, 'show'])->name('customer.show');
        Route::DELETE('customers/{customer}', [CustomerController::class, 'delete'])->name('customers.delete');
        Route::POST('customers', [CustomerController::class, 'store'])->name('customer.store');
        Route::PUT('customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::GET('customers/{customer}/addresses', [CustomerController::class, 'getAddresses'])->name('customers.addresses');
        Route::GET('customers/{customer}/contacts', [CustomerController::class, 'getContacts'])->name('customers.contacts');
        //address
        //Route::POST('set/address', [AddressController::class,'setAddress'])->name('setaddress');
        Route::POST('addresses/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::PUT('addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::GET('addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::GET('addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');
        Route::DELETE('addresses/{address}', [AddressController::class, 'delete'])->name('addresses.delete');

        //contacts
        Route::POST('contacts/create', [ContactController::class, 'create'])->name('contacts.create');
        Route::PUT('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
        Route::GET('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::GET('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::DELETE('contacts/{contact}', [ContactController::class, 'delete'])->name('contacts.delete');

        //global Address
        Route::GET('global/addresses', [GlobalAddressController::class, 'index'])->name('global.addresses.index');

        //Purchase
        Route::GET('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::POST('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::PUT('purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
        Route::GET('purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
        Route::DELETE('purchases/{purchase}', [PurchaseController::class, 'delete'])->name('purchases.delete');
        
        //sales
        Route::GET('sales', [SaleController::class, 'index'])->name('sales.index');
        Route::POST('sales', [SaleController::class, 'store'])->name('sales.store');
        Route::PUT('sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
        Route::GET('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::DELETE('sales/sale}', [SaleController::class, 'delete'])->name('sales.delete');
    });
});

//public route
// Route::group(['middleware' => ['cors']], function () {
Route::POST('/login', [LoginController::class, 'login'])->name('login.api');
Route::POST('/register', [RegistrationController::class, 'register'])->name('register.api');
// });
