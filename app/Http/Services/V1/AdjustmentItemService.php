<?php
namespace App\Http\Services\V1;

use App\Models\AdjustmentItem;
use Illuminate\Support\Facades\DB;

class AdjustmentItemService{


    public function store($adjustmentItem){
        $insertData = [
            'inventory_adjustment_id' => $adjustmentItem['inventory_adjustment_id'],
            'product_id' => $adjustmentItem['product_id'],
            'warehouse_id' => $adjustmentItem['warehouse_id'],
            'item_adjustment_date' => $adjustmentItem['item_adjustment_date'],
            'quantity' => $adjustmentItem['quantity'],
            'quantity_available' => $adjustmentItem['quantity_available'],
            'new_quantity_on_hand' => $adjustmentItem['new_quantity_on_hand'],
            'description' => $adjustmentItem['description'],
            'status' => $adjustmentItem['status'],

        ];
        $adjustmentItem = AdjustmentItem::create($insertData);

        if ($adjustmentItem['status'] == 1) {
            $this->stockUpdate($adjustmentItem['quantity'], $adjustmentItem['product_id'], $adjustmentItem['warehouse_id']);
        };
        return $adjustmentItem;
    }

    public function update($request, $purchaseItem){

        
    }

    public function stockUpdate($quantity, $product_id, $warehouse_id)
    {

        DB::statement("UPDATE stocks SET quantity_on_hand = quantity_on_hand+'$quantity' WHERE product_id='$product_id' and warehouse_id='$warehouse_id'");
    }

}
