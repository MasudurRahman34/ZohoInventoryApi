<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegistrationController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\CustomerController;
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

Route::middleware('auth:api')->group(function() {
    Route::post('/logout', [LoginController::class,'logout'])->name('logout.api');
    
  Route::group(['prefix' => 'v1'],function(){
    //account
    Route::post('account/create', [AccountController::class,'updateOrCreate'])->name('account.create');
    Route::get('accounts', [AccountController::class,'accounts'])->name('accounts');
    
    //user
    //Route::post('user/create', [UserController::class,'updateOrCreate'])->name('user.create');
    Route::post('user/{id}', [UserController::class,'update'])->name('user.update');
    Route::get('users', [UserController::class,'users'])->name('users');
    Route::get('user/{id}', [UserController::class,'user'])->name('user');

    //supplier
    Route::post('suppliers/create', [SupplierController::class,'create'])->name('suppliers.create');
    Route::get('suppliers', [SupplierController::class,'index'])->name('suppliers.index');
    Route::get('suppliers/{supplier}', [SupplierController::class,'show'])->name('suppliers.show');
    Route::delete('suppliers/{supplier}', [SupplierController::class,'delete'])->name('suppliers.delete');
    Route::post('suppliers/store', [SupplierController::class,'store'])->name('suppliers.store');
    Route::post('suppliers/{supplier}', [SupplierController::class,'update'])->name('suppliers.update');

    //customer
    Route::post('customers/create', [CustomerController::class,'create'])->name('customer.create');
    Route::get('customers', [CustomerController::class,'index'])->name('customers.index');
    Route::get('customers/{customer}', [CustomerController::class,'show'])->name('customer.show');
    Route::delete('customers/{customers}', [CustomerController::class,'delete'])->name('customers.delete');
    Route::post('customers/store', [CustomerController::class,'store'])->name('customer.store');
    Route::post('customers/{customer}', [CustomerController::class,'update'])->name('customer.update');
    
    //address
    //Route::post('set/address', [AddressController::class,'setAddress'])->name('setaddress');
    Route::post('addresses/create', [AddressController::class,'create'])->name('addresses.create');
    Route::post('addresses/{address}', [AddressController::class,'update'])->name('addresses.update');
    Route::get('addresses', [AddressController::class,'index'])->name('addresses.index');
    Route::get('addresses/{address}', [AddressController::class,'show'])->name('addresses.show');
    Route::delete('addresses/{address}', [AddressController::class,'delete'])->name('addresses.delete');

    //contacts
    Route::post('contacts/create', [ContactController::class,'create'])->name('contacts.create');
    Route::post('contacts/{contact}', [ContactController::class,'update'])->name('contacts.update');
    Route::get('contacts', [ContactController::class,'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class,'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [ContactController::class,'delete'])->name('contacts.delete');
});
   

});

//public route
Route::group(['middleware' => ['cors']], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login.api');
    Route::post ('/register',[RegistrationController::class,'register'])->name('register.api');
});


