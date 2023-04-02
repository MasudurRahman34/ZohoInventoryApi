<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\v1\StreetAddressResource;
use App\Http\Resources\v1\UnionResource;
use App\Models\Location\StreetAddress;
use App\Models\Location\Union;
use Illuminate\Http\Request;

class UnionController extends BaseController
{
    public function index()
    {
        try {
            $areas = Union::where('status', 'active')->get();

            if (count($areas) > 0) {
                $areaResource = UnionResource::collection($areas);
                return $this->success($areaResource);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function getStreetAddressByArea(Request $request, $areaID)
    {
        try {

            $streetAddress = StreetAddress::where(['union_id' => $areaID, 'status' => 'active'])->get();

            if (count($streetAddress) > 0) {
                $streetAddressResource = StreetAddressResource::collection($streetAddress);
                return $this->success($streetAddressResource);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
}
