<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Location\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\Location\District;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Response as HttpResponse;
use PhpParser\Node\Stmt\TryCatch;

class LocationController extends Controller
{
    use ApiResponse, ApiFilter;
    public function states(Request $request)
    {
        try {
            $query = State::select('id', 'country_iso2', 'country_iso3', 'state_name', 'state_slug');
            $query = $this->filterBy($request, $query);
            $states = $this->query->get();
            if (count($states) > 0) {
                return $this->success($states);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function districts(Request $request)
    {
        try {
            $query = District::select('id', 'state_id', 'district_name', 'district_slug');
            $query = $this->filterBy($request, $query);
            $districts = $this->query->get();
            if (count($districts) > 0) {
                return $this->success($districts);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
    public function thanas(Request $request)
    {
        try {
            $query = Thana::select('id', 'district_id', 'thana_name', 'thana_slug');
            $query = $this->filterBy($request, $query);
            $thanas = $this->query->get();
            if (count($thanas) > 0) {
                return $this->success($thanas);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function unions(Request $request)
    {
        try {
            $query = Union::select('id', 'thana_id', 'union_name', 'union_slug');
            $query = $this->filterBy($request, $query);
            $unions = $this->query->get();
            if (count($unions) > 0) {
                return $this->success($unions);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
    public function zipcodes(Request $request)
    {
        try {
            $query = Zipcode::select('id', 'union_id', 'zip_code');
            $query = $this->filterBy($request, $query);
            $zipcodes = $this->query->get();
            if (count($zipcodes) > 0) {
                return $this->success($zipcodes);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
    public function streetAdress(Request $request)
    {
        try {
            $query = StreetAddress::select('id', 'union_id', 'street_address_value');
            $query = $this->filterBy($request, $query);
            $streetAdress = $this->query->get();
            if (count($streetAdress) > 0) {
                return $this->success($streetAdress);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
}
