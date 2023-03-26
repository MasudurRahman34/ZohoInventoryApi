<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\InventoryAdjustmentRequest;
use App\Http\Resources\v1\InventoryAdjustmentResource;
use App\Http\Services\V1\AdjustmentItemService;
use App\Http\Services\V1\InventoryAdjustmentService;
use App\Models\AdjustmentItem;
use App\Models\InventoryAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryAdjustmentController extends Controller

{
    use ApiResponse, ApiFilter;
    private $inventoryAdjustmentService;
    private $adjustmentItemService;
    public function __construct(InventoryAdjustmentService $inventoryAdjustmentService, AdjustmentItemService $adjustmentItemService)
    {
        $this->inventoryAdjustmentService = $inventoryAdjustmentService;
        $this->adjustmentItemService = $adjustmentItemService;
    }


    public function index(Request $request)
    {
        $this->setFilterProperty($request);

        $query = InventoryAdjustment::query();
        $query = $query->with(['adjustmentItems', 'itemAdjustmentReason']);
        $this->dateRangeQuery($request, $query, 'inventory_adjustments.adjustment_date');
        $this->filterBy($request, $this->query);
        $inventoryAdjustment = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return InventoryAdjustmentResource::collection($inventoryAdjustment);
    }

    public function show($uuid)
    {


        $inventoryAdjustment = InventoryAdjustment::uuid($uuid)->with(['adjustmentItems', 'itemAdjustmentReason'])->first();
        if ($inventoryAdjustment) {
            return $this->success(new InventoryAdjustmentResource($inventoryAdjustment));
        }
        return $this->dataNotFound();
    }
    public function store(InventoryAdjustmentRequest $request)
    {
        //return $request;
        $request = $request->all();
        try {
            DB::beginTransaction();
            $inventoryAdjustment = $this->inventoryAdjustmentService->store($request);
            DB::commit();

            $inventoryAdjustment = InventoryAdjustment::with('adjustmentItems')->find($inventoryAdjustment->id);
            // return $inventoryAdjustment;
            return $this->success(new InventoryAdjustmentResource($inventoryAdjustment));
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    // public function itemUpdate(Request $request, $itemId)
    // {
    //     $adjustmentItem = AdjustmentItem::find($itemId);

    //     if ($adjustmentItem) {
    //         try {
    //             DB::beginTransaction();
    //             $this->adjustmentItemService->update($request, $adjustmentItem);
    //             Db::commit();
    //             return $this->success($adjustmentItem->refresh());
    //         } catch (\Exception $th) {
    //             return $this->error($th->getMessage(), 422);
    //         }
    //     }
    // }

    public function itemStatusUpdate(Request $request, $itemId)
    {

        $adjustmentItem = AdjustmentItem::find($itemId);

        if ($adjustmentItem) {
            try {
                DB::beginTransaction();
                $this->adjustmentItemService->updateStatus($request, $adjustmentItem);
                Db::commit();
                return $this->success($adjustmentItem->refresh());
            } catch (\Exception $th) {
                return $this->error($th->getMessage(), 422);
            }
        }
    }
}
