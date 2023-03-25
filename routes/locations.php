<?php

use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\LocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\StateController;

Route::GET('countries', [CountryController::class, 'index'])->name('countries.index');
Route::GET('countries/{Iso2}/states', [StateController::class, 'getStatesBycountry'])->name('location.states');
Route::GET('districts', [LocationController::class, 'districts'])->name('location.districts');
Route::GET('thanas', [LocationController::class, 'thanas'])->name('location.thanas');
Route::GET('unions', [LocationController::class, 'unions'])->name('location.unions');
Route::GET('zipcodes', [LocationController::class, 'zipcodes'])->name('location.zipcodes');
Route::GET('street-adresses', [LocationController::class, 'streetAdress'])->name('location.streetAdress');

Route::post('addnew/autocomplete', [LocationController::class, 'addNew'])->name('location.add-new');

Route::get('addnew/autocomplete', [LocationController::class, 'show'])->name('location.add-new');
