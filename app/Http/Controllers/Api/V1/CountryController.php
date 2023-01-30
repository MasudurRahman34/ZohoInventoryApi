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
        $countries = Country::select('id', 'country_code', 'country_name')->get();
        return $this->success(new CountryCollection($countries));
    }
}
