<?php
namespace App\Http\Services\V1;

use App\Models\PurchaseItem;

class PurchaseItemService{


    public function store($purchaseItem){
        $line_insert = [
            'purchase_id'=>$purchaseItem['purchase_id'],
            'warehouse_id'=>$purchaseItem['warehouse_id'],
            "product_id" => $purchaseItem['product_id'],
            "product_qty" => $purchaseItem['product_qty'],
            "received_qty" => $purchaseItem['received_qty'],
            "unit_price" => $purchaseItem['unit_price'],
            "product_discount" => $purchaseItem['product_discount'],
            "product_tax" => $purchaseItem['product_tax'],
            "subtotal" => $purchaseItem['subtotal'],
            "description" => $purchaseItem['description'],
            'is_serialized'=>$purchaseItem['is_serialized'],
            'expire_date'=>$purchaseItem['expire_date'],
            'package_date'=>$purchaseItem['package_date'],

        ];
        if($purchaseItem['is_serialized']==1){
            $line_insert['serial_number']=$purchaseItem['generateSerialNumber'];
            $line_insert['product_qty']=1;
        }

        $response = PurchaseItem::create($line_insert);

    
    return $response;
    }

    public function update($request, $customer){

        
    }
}
