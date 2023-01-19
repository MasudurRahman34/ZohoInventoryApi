<?php
namespace App\Http\Services\V1;

use App\Models\PurchaseItem;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\PurchaseItemResource;
use App\Models\SaleItem;

class SaleItemService{
 use ApiResponse;

    public function store($saleItem){
        $insertData = [
            'product_id' => $saleItem['product_id'],
            'sale_id' => $saleItem['sale_id'],
            'warehouse_id' => $saleItem['warehouse_id'],
            'description' => $saleItem['description'],
            'serial_number' => $saleItem['serial_number'],
            'product_qty' => $saleItem['product_qty'],
            'packed_qty' => $saleItem['packed_qty'],
            'shipped_qty' => $saleItem['shipped_qty'],
            'invoice_qty' => $saleItem['invoice_qty'],
            'unit_price' => $saleItem['unit_price'],
            'product_discount' => $saleItem['product_discount'],
            'product_tax' => $saleItem['product_tax'],
            'subtotal' => $saleItem['subtotal'],
           'is_serialized'=>$saleItem['is_serialized']

        ];
        // if($purchaseItem['is_serialized']==1){
        //     $insertData['serial_number']=$purchaseItem['generateSerialNumber'];
        //     $insertData['product_qty']=1;
        // }else if($purchaseItem['is_serialized']==0){
        //     $insertData['serial_number']=$purchaseItem['serial_number'];
        // }

        $saleItem = SaleItem::create($insertData);
        return $saleItem;
    }

    public function update($request, $purchaseItem){

        
    }

}
