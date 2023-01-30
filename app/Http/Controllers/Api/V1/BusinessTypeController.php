<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BusinessTypeRequest;
use App\Http\Services\V1\BusinessTypeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\BusinessTypeResource;
use App\Models\BusinessType;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class BusinessTypeController extends Controller
{
    use ApiResponse;
    private $businessTypeService;
    public function __construct(BusinessTypeService $businessTypeService)
    {
        $this->businessTypeService = $businessTypeService;
    }
    public function index(Request $request)
    {
        $businessTypes = BusinessType::with('childRecursive')->where('parent_id', 0)->get();
        return $this->success(new ResourceCollection($businessTypes));
    }

    public function store(BusinessTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $newBusinessType = $this->businessTypeService->store($request->validated());
            DB::commit();
            return $this->success(new BusinessTypeResource($newBusinessType));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return  $this->error($th->getMessage(), 422);
        }
    }
    public function update(BusinessTypeRequest $request, $id)

    {
        $businessType = BusinessType::find($id);

        if ($businessType) {
            try {
                DB::beginTransaction();
                $unpdatedBusinessType = $this->businessTypeService->update($request, $businessType);
                //return $unpdatedBusinessType;
                DB::commit();
                return $this->success(new BusinessTypeResource($businessType), 200);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), 200);
            }
        } else {
            return $this->error("data Not Found", 200);
        }
    }

    public function show($id)
    {
        $businessType = BusinessType::with('child')->find($id);
        if ($businessType) {
            return $this->success(new BusinessTypeResource($businessType));
        } else {
            $this->error("data Not Found", 404);
        }
    }
    public function delete()
    {
    }
}
