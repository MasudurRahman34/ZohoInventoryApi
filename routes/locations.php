<?php

use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\LocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\StateController;
use App\Http\Controllers\Api\V1\DistrictController;
use App\Http\Controllers\Api\V1\ThanaController;
use App\Http\Controllers\Api\V1\UnionController;

Route::GET('countries', [CountryController::class, 'index'])->name('countries.index');
Route::GET('countries/{Iso2}/states', [CountryController::class, 'getStatesBycountry'])->name('location.states');

Route::GET('states', [StateController::class, 'index'])->name('states.index');
Route::GET('states/{stateID}/disticts', [StateController::class, 'getDistictByState'])->name('state.disticts');

Route::GET('districts', [DistrictController::class, 'index'])->name('districts.index');
Route::GET('districts/{districtID}/thanas', [DistrictController::class, 'getThanaByDistrict'])->name('districts.thanas');

Route::GET('thanas', [ThanaController::class, 'index'])->name('thanas.index');
Route::GET('thanas/{thanaID}/areas', [ThanaController::class, 'getAreaByThana'])->name('thanas.getAreaByThana');
Route::GET('thanas/{thanaID}/zipcodes', [ThanaController::class, 'getZipcodeByThana'])->name('thanas.getZipcodeByThana');

Route::GET('areas', [UnionController::class, 'index'])->name('location.index');
Route::GET('street-adresses', [LocationController::class, 'streetAdress'])->name('location.streetAdress');
Route::GET('areas/{areaID}/street-addresses', [LocationController::class, 'streetAdress'])->name('location.streetAdress');

Route::POST('autocomplete/add', [LocationController::class, 'addNew'])->name('location.add-new');

//Route::get('addnew/autocomplete', [LocationController::class, 'show'])->name('location.add-new');
