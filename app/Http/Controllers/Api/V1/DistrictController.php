<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DistrictResource;
use App\Http\Resources\v1\ThanaResource;
use App\Models\Location\District;
use App\Models\Location\Thana;
use Illuminate\Http\Request;

class DistrictController extends BaseController
{

    public function index()
    {
        try {
            $districts = District::where('status', 'active')->get();

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
    public function getThanaByDistrict(Request $request, $districtID)
    {
        try {

            $thanas = Thana::where(['district_id' => $districtID, 'status' => 'active'])->get();

            if (count($thanas) > 0) {
                $thanaResource = ThanaResource::collection($thanas);
                return $this->success($thanaResource);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
}
