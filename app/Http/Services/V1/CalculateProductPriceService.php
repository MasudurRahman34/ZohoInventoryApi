<?php
namespace App\Http\Services\V1;

use App\Models\Purchase;

class CalculateProductPriceService{


    public function purchasePrice($request){
   
        
   
        $purchase= [
            'supplier_id' => $request['supplier_id'],
            'warehouse_id' => $request['warehouse_id'],
            'invoice_no' => isset($request['invoice_no']) ? $request['invoice_no'] : NULL,
            'reference' => isset($request['reference']) ? $request['reference'] : NULL,

            //product expenditure initailazation
            // 'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
            'total_amount' => 0,
            'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
            'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
            // 'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
            'grand_total_amount' => 0,
            'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : 0,
            'discount_currency' => isset($request['discount_currency']) ? $request['discount_currency'] : 0,
            'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,
            'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
            'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
            'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,
            'tax_rate'=>isset($request['tax_rate']) ? $request['tax_rate'] : null,

            //

            'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
            'purchase_date' => isset($request['purchase_date']) ? $request['purchase_date'] : NULL,
            'delivery_date' => isset($request['delivery_date']) ? $request['delivery_date'] : NULL,
            'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] : NULL,
            'image' => isset($request['image']) ? $request['image'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : '0',
            'calculated_total'=>0,
            // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

        ];
        
        
        if ($request->has('purchaseItems')){
            $purchaseItems=[];
            foreach($request->purchaseItems as $key => $item){
                $purchaseItems[$key]= 
                [
                    "product_id" => $item['product_id'],
                    "product_qty" => isset($item['product_qty']) ? $item['product_qty'] : 0,
                    "received_qty" => isset($item['received_qty']) ? $item['received_qty']:0,
                    "unit_price" => isset($item['unit_price']) ? $item['unit_price']:0,
                    "product_discount" => isset($item['product_discount']) ?$item['product_discount'] :0,
                    "product_tax" => isset($item['product_tax']) ? $item['product_tax'] :0,
                    // "subtotal" => isset($item['subtotal']) ? $item['subtotal']:0,
                    "subtotal" =>  0,

                    "is_taxable"=>isset($item['is_taxable']) ? $item['is_taxable']:0,

                    "description" => isset($item['description']) ? $item['description']:0,
                    'is_serialized'=>isset($item['is_serialized']) ? $item['is_serialized'] :0,
                    'expire_date'=>isset($item['expire_date']) ? $item['expire_date'] :NULL,
                    'package_date'=>isset($item['package_date']) ? $item['package_date'] :NULL,
        
                ];
                //override price;
                $purchaseItems[$key]['subtotal']= ($purchaseItems[$key]['unit_price'] * $purchaseItems[$key]['product_qty']) - $purchaseItems[$key]['product_discount'];
                if ($purchaseItems[$key]['is_taxable']==1) {
                    $purchaseItems[$key]['subtotal']=$purchaseItems[$key]['subtotal']-($purchaseItems[$key]['subtotal'] *($purchaseItems[$key]['product_tax']/100));
                }
                $purchase['total_amount']+=$purchaseItems[$key]['subtotal'];
                
            }
            $purchase['grand_total_amount']= ($purchase['total_amount'] + $purchase['shipping_charge'] + $purchase['order_adjustment'])- ($purchase['total_amount']*($purchase['order_discount']/100));
            $purchase['purchaseItems']=$purchaseItems;

            

        }

        
        
        return $purchase;
    }

    public function update($request, $purchase){

        
    }
}
