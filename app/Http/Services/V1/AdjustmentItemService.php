<?php
namespace App\Http\Services\V1;

use App\Models\AdjustmentItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class AdjustmentItemService{


    public function store($adjustmentItem){
        $stock=Stock::where('product_id',$adjustmentItem['product_id'])->where('warehouse_id',$adjustmentItem['warehouse_id'])->first();
       
       //return $stock;
       if($stock){
        $stock_on_hand=$stock->quantity_on_hand;
       }else{
        $stock_on_hand=0;
       }
       
        $insertData = [
            'inventory_adjustment_id' => $adjustmentItem['inventory_adjustment_id'],
            'product_id' => $adjustmentItem['product_id'],
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

    public function update($request, $purchaseItem){

        
    }

    public function stockUpdate($quantity, $product_id, $warehouse_id)
    {

        DB::statement("UPDATE stocks SET quantity_on_hand = quantity_on_hand+'$quantity' WHERE product_id='$product_id' and warehouse_id='$warehouse_id'");
    }

}
