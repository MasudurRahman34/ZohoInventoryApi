<?php
namespace App\Http\Services\V1;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SaleService{


    public function store($request){
   
        $saleData = [
            'customer_id' => $request['customer_id'],
                'warehouse_id' => $request['warehouse_id'],
                'order_number' => isset($request['order_number']) ? $request['order_number'] : NULL,
                'sales_order_date' => isset($request['sales_order_date']) ? $request['sales_order_date'] : NULL,
                'expected_shipment_date' => isset($request['expected_shipment_date']) ? $request['expected_shipment_date'] : NULL,
                'billing_address' => isset($request['billing_address']) ? $request['billing_address'] : NULL,
                'shipping_address' => isset($request['shipping_address']) ? $request['shipping_address'] : NULL,
                'delivery_method' => isset($request['delivery_method']) ? $request['delivery_method'] : NULL,
                'reference' => isset($request['reference']) ? $request['reference'] : NULL,
                'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : 0,
                'discount_currency' => isset($request['discount_currency']) ? $request['discount_currency'] : 0,
                'order_discount_amount' => isset($request['order_discount_amount']) ? $request['order_discount_amount'] : 0,
                'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,
                'order_tax_amount' => isset($request['order_tax_amount']) ? $request['order_tax_amount'] : 0,
                'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
                'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
                'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
                'customer_note' => isset($request['customer_note']) ? $request['customer_note'] : NULL,
                'terms_condition' => isset($request['terms_condition']) ? $request['terms_condition'] : NULL,

                'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
                'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
                'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
                'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
                'recieved_amount' => isset($request['recieved_amount']) ? $request['recieved_amount'] : 0,
                'changed_amount' => isset($request['changed_amount']) ? $request['changed_amount'] : 0,                
                'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,
                'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] : NULL,
                'image' => isset($request['image']) ? $request['image'] : NULL,
                'offer_to' => isset($request['offer_to']) ? $request['offer_to'] : NULL,
                'offer_subject' => isset($request['offer_subject']) ? $request['offer_subject'] : NULL,
                'offer_greetings' => isset($request['offer_greetings']) ? $request['offer_greetings'] : NULL,
                'offer_terms_condition' => isset($request['offer_terms_condition']) ? $request['offer_terms_condition'] : NULL,   
                'invoice_status' => isset($request['invoice_status']) ? $request['invoice_status'] : '0',
                'shipment_status' => isset($request['shipment_status']) ? $request['shipment_status'] : '0',
                'status' => isset($request['status']) ? $request['status'] : '0',
                'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',
                'sales_type' => isset($request['sales_type']) ? $request['sales_type'] : '0',
                'salesperson' => Auth::user()->id,
            // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

        ];
        $sale = Sale::create($saleData);
        return $sale;
    }

    public function update($request, $purchase){

        
    }
}
