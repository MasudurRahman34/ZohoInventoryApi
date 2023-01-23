<?php

namespace App\Http\Services\V1;

use App\Http\Resources\v1\PurchaseResource;
use App\Models\PurchaseItem;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\PurchaseItemResource;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\NullType;

class PurchaseItemService
{
    use ApiResponse;

    public function store($purchaseItem)
    {
        $insertData = [
            'purchase_id' =>  $purchaseItem['purchase_id'],
                    "product_id" => $purchaseItem['product_id'],
                    'warehouse_id' => $purchaseItem['warehouse_id'],
                    "product_qty" => isset($purchaseItem['product_qty']) ? $purchaseItem['product_qty'] : 0,
                    "received_qty" => isset($purchaseItem['received_qty']) ? $purchaseItem['received_qty'] : 0,
                    "unit_price" => isset($purchaseItem['unit_price']) ? $purchaseItem['unit_price'] : 0,
                    "product_discount" => isset($purchaseItem['product_discount']) ? $purchaseItem['product_discount'] : 0,
                    "product_tax" => isset($purchaseItem['product_tax']) ? $purchaseItem['product_tax'] : 0,
                    "subtotal" => isset($purchaseItem['subtotal']) ? $purchaseItem['subtotal'] : 0,
                    "description" => isset($purchaseItem['description']) ? $purchaseItem['description'] : NULL,
                    'is_serialized' => isset($purchaseItem['is_serialized']) ? $purchaseItem['is_serialized'] : 0,
                    'expire_date' => isset($purchaseItem['expire_date']) ? $purchaseItem['expire_date'] : NULL,
                    'package_date' => isset($purchaseItem['package_date']) ? $purchaseItem['package_date'] : NULL,
                    "sold_qty" => isset($purchaseItem['sold_qty']) ? $purchaseItem['sold_qty'] : 0,
                    'status' => isset($purchaseItem['status']) ? $purchaseItem['status'] : 0,

        ];
        if ($purchaseItem['is_serialized'] == 1) {
            $insertData['serial_number'] = $purchaseItem['generateSerialNumber'];
            $insertData['product_qty'] = 1;
        } else if ($purchaseItem['is_serialized'] == 0) {
            $insertData['serial_number'] = $purchaseItem['serial_number'];
        }

        $response = PurchaseItem::create($insertData);


        return $response;
    }


    public function updateOrCreate($request)
    {
        $item = PurchaseItem::find($request['id']);

        if ($item) {
            $item->update(
                [
                    'purchase_id' => isset($request['purchase_id']) ? $request['purchase_id'] : $item['purchase_id'],
                    "product_id" => isset($request['product_id']) ? $request['product_id'] : $item['product_id'],
                    'warehouse_id' => isset($request['warehouse_id']) ? $request['warehouse_id'] : $item['warehouse_id'],
                    "product_qty" => isset($request['product_qty']) ? $request['product_qty'] : $item['product_qty'],
                    "received_qty" => isset($request['received_qty']) ? $request['received_qty'] : $item['received_qty'],
                    "unit_price" => isset($request['unit_price']) ? $request['unit_price'] : $item['unit_price'],
                    "product_discount" => isset($request['product_discount']) ? $request['product_discount'] : $item['product_discount'],
                    "product_tax" => isset($request['product_tax']) ? $request['product_tax'] : $item['product_tax'],
                    "subtotal" => isset($request['subtotal']) ? $request['subtotal'] : $item['subtotal'],
                    "description" => isset($request['description']) ? $request['description'] : $item['description'],
                    'is_serialized' => isset($request['is_serialized']) ? $request['is_serialized'] : $item['is_serialized'],
                    'expire_date' => isset($request['expire_date']) ? $request['expire_date'] : $item['expire_date'],
                    'package_date' => isset($request['package_date']) ? $request['package_date'] : $item['package_date'],
                    "sold_qty" => isset($request['sold_qty']) ? $request['sold_qty'] : $item['sold_qty'],
                    'status' => isset($request['status']) ? $request['status'] : $item['purchase_id'],
                ]
            );
        } else {
            $item = PurchaseItem::create([
                'purchase_id' =>  $request['purchase_id'],
                    "product_id" => $request['product_id'],
                    'warehouse_id' => $request['warehouse_id'],
                    "product_qty" => isset($request['product_qty']) ? $request['product_qty'] : 0,
                    "received_qty" => isset($request['received_qty']) ? $request['received_qty'] : 0,
                    "unit_price" => isset($request['unit_price']) ? $request['unit_price'] : 0,
                    "product_discount" => isset($request['product_discount']) ? $request['product_discount'] : 0,
                    "product_tax" => isset($request['product_tax']) ? $request['product_tax'] : 0,
                    "subtotal" => isset($request['subtotal']) ? $request['subtotal'] : 0,
                    "description" => isset($request['description']) ? $request['description'] : NULL,
                    'is_serialized' => isset($request['is_serialized']) ? $request['is_serialized'] : 0,
                    'expire_date' => isset($request['expire_date']) ? $request['expire_date'] : NULL,
                    'package_date' => isset($request['package_date']) ? $request['package_date'] : NULL,
                    "sold_qty" => isset($request['sold_qty']) ? $request['sold_qty'] : 0,
                    'status' => isset($request['status']) ? $request['status'] : 0,
            ]);
        }
        return $item;
    }

    public function update($request ,$item)
    {
      
            $item->update(
                [
                    'purchase_id' => isset($request['purchase_id']) ? $request['purchase_id'] : $item['purchase_id'],
                    "product_id" => isset($request['product_id']) ? $request['product_id'] : $item['product_id'],
                    'warehouse_id' => isset($request['warehouse_id']) ? $request['warehouse_id'] : $item['warehouse_id'],
                    "product_qty" => isset($request['product_qty']) ? $request['product_qty'] : $item['product_qty'],
                    "received_qty" => isset($request['received_qty']) ? $request['received_qty'] : $item['received_qty'],
                    "unit_price" => isset($request['unit_price']) ? $request['unit_price'] : $item['unit_price'],
                    "product_discount" => isset($request['product_discount']) ? $request['product_discount'] : $item['product_discount'],
                    "product_tax" => isset($request['product_tax']) ? $request['product_tax'] : $item['product_tax'],
                    "subtotal" => isset($request['subtotal']) ? $request['subtotal'] : $item['subtotal'],
                    "description" => isset($request['description']) ? $request['description'] : $item['description'],
                    'is_serialized' => isset($request['is_serialized']) ? $request['is_serialized'] : $item['is_serialized'],
                    'expire_date' => isset($request['expire_date']) ? $request['expire_date'] : $item['expire_date'],
                    'package_date' => isset($request['package_date']) ? $request['package_date'] : $item['package_date'],
                    "sold_qty" => isset($request['sold_qty']) ? $request['sold_qty'] : $item['sold_qty'],
                    'status' => isset($request['status']) ? $request['status'] : $item['purchase_id'],
                ]
            );
        return $item;
    }


    public function showBySerialNumber($serialNumeber)
    {
        //need to get all kinds of product data.
        try {
            $purchaseItem = PurchaseItem::where('serial_number', $serialNumeber)->first();
            if ($purchaseItem) {
                return $this->success(new PurchaseItemResource($purchaseItem), 200);
            } else {
                return $this->error('Data Not found', 200);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function delete($id){
        $purchaseItem = PurchaseItem::find($id);
        if ($purchaseItem) {
            try {
                DB::beginTransaction();
                $purchaseItem->delete();
                DB::commit();
                return $this->success(null, 200);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error('Data Not Found', 201);
        };
    }
}
