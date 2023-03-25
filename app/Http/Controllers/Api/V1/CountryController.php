<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Collections\CountryCollection;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        $countries = Country::select('id', 'iso2', 'iso3', 'calling_code', 'country_name')->orderBy('country_name', 'ASC')->get();
        return $this->success(new CountryCollection($countries));
    }
}
