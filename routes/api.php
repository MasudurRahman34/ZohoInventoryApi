<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
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
});

//public route
Route::group(['middleware' => ['cors']], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login.api');
    Route::post ('/register',[RegistrationController::class,'register'])->name('register.api');
});


