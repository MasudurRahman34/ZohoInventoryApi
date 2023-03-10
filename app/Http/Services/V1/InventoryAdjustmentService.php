<?php

namespace App\Http\Services\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\InventoryAdjustment;
use Illuminate\Support\Facades\DB;


class InventoryAdjustmentService
{
    use ApiResponse;
    private $adjustmentItemService;
    public function __construct(AdjustmentItemService $adjustmentItemService)
    {
        $this->adjustmentItemService = $adjustmentItemService;
    }

    public function store($request)
    {
        // return count($request['adjustmentItems']);
        if ($request['source'] === 'sale') {
            $inventory_adjustmentable_type = InventoryAdjustment::$sale_table;
        } elseif ($request['source'] === 'purchase') {
            $inventory_adjustmentable_type = InventoryAdjustment::$purchase_table;
        } elseif ($request['source'] === 'inventory_adjustment') {
            $inventory_adjustmentable_type = InventoryAdjustment::$inventory_adjustment_table;

            // $id=DB::select("SHOW TABLE STATUS LIKE 'inventory_adjustments'");
            // $request['inventory_adjustmentable_id']=$id[0]->Auto_increment;
            $request['inventory_adjustmentable_id'] = 0; // InventoryAdjustment::nextId() used to add seft adjustment  and has problem of getting next id

        } else {
            $message['source'][] = "The source value deos not match.";
            return $this->error($message, 422);
        }
        $insertData = [
            'mode_of_adjustment' => $request['mode_of_adjustment'],
            'inventory_adjustmentable_id' => $request['inventory_adjustmentable_id'],
            'inventory_adjustmentable_type' => $inventory_adjustmentable_type,
            'reference_number' => $request['reference_number'],
            'adjustment_date' => $request['adjustment_date'],
            'account' => $request['account'],
            'reason_id' => $request['reason_id'],
            'warehouse_id' => $request['warehouse_id'],
            'description' => $request['description'],

        ];

        $inventoryAdjustment = InventoryAdjustment::create($insertData);
        if ($inventory_adjustmentable_type == InventoryAdjustment::$inventory_adjustment_table) {
            $inventoryAdjustment->update(['inventory_adjustmentable_id' => $inventoryAdjustment->id]);
        }

        if ((count($request['adjustmentItems'])) > 0) {
            foreach ($request['adjustmentItems'] as $key => $item) {
                $item['inventory_adjustment_id'] = $inventoryAdjustment->id;
                $this->adjustmentItemService->store($item);
            }
        }
        return $inventoryAdjustment;
    }

    public function update($request, $purchaseItem)
    {
    }
}
