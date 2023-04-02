<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ThanaResource;
use App\Http\Resources\v1\UnionResource;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
use Illuminate\Http\Request;

class ThanaController extends BaseController
{
    public function index()
    {
        try {
            $thanas = Thana::where('status', 'active')->get();

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

    public function getAreaByThana(Request $request, $thanaID)
    {
        try {
            $unions = Union::where(['thana_id' => $thanaID, 'status' => 'active'])->get();

            if (count($unions) > 0) {
                $unionResource = UnionResource::collection($unions);
                return $this->success($unionResource);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function getZipcodeByThana(Request $request, $thanaID)
    {
        try {
            $zipcodes = Zipcode::where(['thana_id' => $thanaID, 'status' => 'active'])->get();

            if (count($zipcodes) > 0) {
                $zipcodesResource = UnionResource::collection($zipcodes);
                return $this->success($zipcodesResource);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
}
