<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Collections\CountryCollection;
use App\Http\Resources\v1\StateResource;
use App\Models\Country;
use App\Models\Location\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        $countries = Country::select('id', 'iso2', 'iso3', 'calling_code', 'country_name')->orderBy('country_name', 'ASC')->get();
        return $this->success(new CountryCollection($countries));
    }

    public function getStatesBycountry(Request $request, $Iso2)
    {
        try {

            $states = State::where(['country_iso2' => $Iso2, 'status' => 'active'])->get();

            if (count($states) > 0) {
                $stateResource = StateResource::collection($states);
                return $this->success($stateResource);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
}
