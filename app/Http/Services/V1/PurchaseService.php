<?php
namespace App\Http\Services\V1;

use App\Models\Purchase;

class PurchaseService{


    public function store($request){
      //return $request['grand_total_amount'];
        $purchaseData = [
            'supplier_id' => $request['supplier_id'],
            'warehouse_id' => $request['warehouse_id'],
            'invoice_no' => isset($request['invoice_no']) ? $request['invoice_no'] : NULL,
            'reference' => isset($request['reference']) ? $request['reference'] : NULL,
            'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
            'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
            'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
            'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
            'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : 0,
            'discount_currency' => isset($request['discount_currency']) ? $request['discount_currency'] : 0,
            'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,
            'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
            'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
            'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,
            'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
            'purchase_date' => isset($request['purchase_date']) ? $request['purchase_date'] : NULL,
            'delivery_date' => isset($request['delivery_date']) ? $request['delivery_date'] : NULL,
            'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] : NULL,
            'image' => isset($request['image']) ? $request['image'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : '0',
            // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

        ];
        $purchase = Purchase::create($purchaseData);
        return $purchase;
    }

    public function update($request, $purchase){

        
    }
}
