<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegistrationController;
use App\Http\Controllers\Api\V1\CustomerController;
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
    Route::post('supplier/create', [SuppliersController::class,'create'])->name('supplier.create');
    Route::get('suppliers', [SuppliersController::class,'suppliers'])->name('suppliers');
    Route::get('supplier/{id}', [SuppliersController::class,'supplier'])->name('supplier');
    Route::post('supplier/store', [SuppliersController::class,'store'])->name('supplier.store');

    //customer
    Route::post('customer/create', [CustomerController::class,'create'])->name('customer.create');
    Route::get('customers', [CustomerController::class,'customers'])->name('customers');
    Route::get('customer/{id}', [CustomerController::class,'customer'])->name('customer');
    Route::post('customer/store', [CustomerController::class,'store'])->name('customer.store');
    
    //address
    Route::post('set/address', [AddressController::class,'setAddress'])->name('setaddress');
    Route::post('address', [AddressController::class,'updateOrCreate'])->name('address.create');
    Route::post('address/{address_id}', [AddressController::class,'updateOrCreate'])->name('address.update');

});
   

});

//public route
Route::group(['middleware' => ['cors']], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login.api');
    Route::post ('/register',[RegistrationController::class,'register'])->name('register.api');
});


