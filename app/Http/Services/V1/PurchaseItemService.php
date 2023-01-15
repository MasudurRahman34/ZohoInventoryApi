<?php
namespace App\Http\Services\V1;

use App\Http\Resources\v1\PurchaseResource;
use App\Models\PurchaseItem;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\PurchaseItemResource;

class PurchaseItemService{
 use ApiResponse;

    public function store($purchaseItem){
        $insertData = [
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
            $insertData['serial_number']=$purchaseItem['generateSerialNumber'];
            $insertData['product_qty']=1;
        }else if($purchaseItem['is_serialized']==0){
            $insertData['serial_number']=$purchaseItem['serial_number'];
        }

        $response = PurchaseItem::create($insertData);

    
    return $response;
    }

    public function update($request, $purchaseItem){

        
    }

    public function showBySerialNumber($serialNumeber){
        try {
            $purchaseItem=PurchaseItem::where('serial_number', $serialNumeber)->first();
            if($purchaseItem){
                return $this->success( new PurchaseItemResource($purchaseItem),200);
            }else{
               return $this->error('Data Not found',200);
            }
            
            
        } catch (\Exception $e) {
           return $this->error($e->getMessage(),422);
        }
    }
}
