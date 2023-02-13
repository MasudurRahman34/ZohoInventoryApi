<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Location\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\Location\District;
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
            $query = District::select('id', 'district_name', 'district_slug');
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
}
