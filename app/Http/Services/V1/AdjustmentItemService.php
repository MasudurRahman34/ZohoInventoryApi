<?php

namespace App\Http\Services\V1;

use App\Models\AdjustmentItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class AdjustmentItemService
{


    public function store($adjustmentItem)
    {

        $stock = Stock::where('product_id', $adjustmentItem['product_id'])->where('warehouse_id', $adjustmentItem['warehouse_id'])->first();

        //return $stock;
        if ($stock) {
            $stock_on_hand = $stock->quantity_on_hand;
        } else {
            $stock_on_hand = 0;
        }

        $insertData = [
            'inventory_adjustment_id' => $adjustmentItem['inventory_adjustment_id'],
            'product_id' => $adjustmentItem['product_id'],
            'product_name' => isset($adjustmentItem['product_name']) ? $adjustmentItem['product_name'] : NULL,
            'warehouse_id' => $adjustmentItem['warehouse_id'],
            'item_adjustment_date' => $adjustmentItem['item_adjustment_date'],
            'quantity' => $adjustmentItem['quantity'],
            'quantity_available' => $stock_on_hand,
            'new_quantity_on_hand' => $stock_on_hand + $adjustmentItem['quantity'],
            'description' => $adjustmentItem['description'],
            'status' => $adjustmentItem['status'],

        ];
        $adjustmentItem = AdjustmentItem::create($insertData);


        if ($adjustmentItem['status'] == 1) {
            $this->stockUpdate($adjustmentItem['quantity'], $adjustmentItem['product_id'], $adjustmentItem['warehouse_id']);
        };
        return $adjustmentItem;
    }

    public function update($request, $adjustmentItem)
    {
        // return 'working';
        $stock = Stock::where('product_id', $adjustmentItem['product_id'])->where('warehouse_id', $adjustmentItem['warehouse_id'])->first();
        if ($stock) {
            $stock_on_hand = $stock->quantity_on_hand;
        } else {
            $stock_on_hand = 0;
        }

        $updateAdjustmentItem = [
            'inventory_adjustment_id' => isset($request['inventory_adjustment_id']) ? $request['inventory_adjustment_id'] : $adjustmentItem['inventory_adjustment_id'],
            'product_id' => isset($request['product_id']) ? $request['product_id'] : $adjustmentItem['product_id'],
            'product_name' => isset($request['product_name']) ? $request['product_name'] : $adjustmentItem['product_name'],
            'warehouse_id' => isset($request['warehouse_id']) ? $request['warehouse_id'] : $adjustmentItem['warehouse_id'],
            'item_adjustment_date' => isset($request['item_adjustment_date']) ? $request['item_adjustment_date'] : $adjustmentItem['item_adjustment_date'],
            'quantity' =>  $request['quantity'],
            'quantity_available' =>  $stock_on_hand,
            'new_quantity_on_hand' => $stock_on_hand + $request['quantity'],
            'description' => isset($request['description']) ? $request['description'] : $adjustmentItem['description'],
            'status' => isset($request['status']) ? $request['status'] : $adjustmentItem['status'],
            'deleted_at' => \null,

        ];
        $update = $adjustmentItem->update($updateAdjustmentItem);

        if ($request['status'] == 1) {
            $this->stockUpdate($adjustmentItem['quantity'], $adjustmentItem['product_id'], $adjustmentItem['warehouse_id']);
        };
        return $adjustmentItem;
    }

    public function updateStatus($request, $adjustmentItem)
    {
        $update = $adjustmentItem->update(["status" => $request['status']]);
        if ($request['status'] == 1) {
            $this->stockUpdate($adjustmentItem['quantity'], $adjustmentItem['product_id'], $adjustmentItem['warehouse_id']);
        };
        return $update;
    }

    public function stockUpdate($quantity, $product_id, $warehouse_id)
    {

        DB::statement("UPDATE stocks SET quantity_on_hand = quantity_on_hand+'$quantity' WHERE product_id='$product_id' and warehouse_id='$warehouse_id'");
        return;
    }
}
