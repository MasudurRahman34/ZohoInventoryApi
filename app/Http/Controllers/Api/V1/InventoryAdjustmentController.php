<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\InventoryAdjustmentRequest;
use App\Http\Resources\v1\InventoryAdjustmentResource;
use App\Http\Services\V1\InventoryAdjustmentService;
use App\Models\InventoryAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryAdjustmentController extends Controller

{
    use ApiResponse;
    private $inventoryAdjustmentService;
     public function __construct(InventoryAdjustmentService $inventoryAdjustmentService = null) {
        $this->inventoryAdjustmentService = $inventoryAdjustmentService;
    }
    public function store(InventoryAdjustmentRequest $request)
    {
        //return $request;
        $request=$request->all();
        try {
            DB::beginTransaction();
            $inventoryAdjustment= $this->inventoryAdjustmentService->store($request);
            DB::commit();
            $inventoryAdjustment=InventoryAdjustment::with('adjustmentItems')->find($inventoryAdjustment->id);
            return $inventoryAdjustment;
            return $this->success(new InventoryAdjustmentResource($inventoryAdjustment));
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(),422);
        }
        
    }
}
