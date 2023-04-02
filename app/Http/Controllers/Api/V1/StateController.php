<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DistrictResource;
use App\Http\Resources\v1\StateResource;
use App\Models\Location\District;
use App\Models\Location\State;
use Illuminate\Http\Request;

class StateController extends BaseController
{
    public function index()
    {
        try {
            $states = State::where('status', 'active')->get();

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

    public function getDistictByState(Request $request, $stateID)
    {
        try {

            $districts = District::where(['state_id' => $stateID, 'status' => 'active'])->get();

            if (count($districts) > 0) {
                $districtResource = DistrictResource::collection($districts);
                return $this->success($districtResource);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
}
