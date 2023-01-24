<?php
namespace App\Http\Services\V1;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Purchase;
use App\Models\PurchaseAddress;

use function PHPUnit\Framework\throwException;

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
            'status' => isset($request['status']) ? $request['status'] : 0,
            // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

        ];
        // $billingAddressId=isset($request['bill_address']) ? $request['bill_address'] : NULL;
        // $shippingAddressId=isset($request['ship_address']) ? $request['bill_address'] : NULL;
        // $billingAddress=Address::where('id',$billingAddressId)->first();
        // $shippingAddress=Address::where('id',$shippingAddressId)->first();
        // return $billingAddress->full_address;
        $purchase = Purchase::create($purchaseData);

        if($purchase){
            $billingAddressId=isset($request['bill_address']) ? $request['bill_address'] : NULL;
            $shippingAddressId=isset($request['ship_address']) ? $request['ship_address'] : NULL;
            $billingAddress=Address::where('id',$billingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key',Address::$ref_supplier_key)->first();
            $shippingAddress=Address::where('id',$shippingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key',Address::$ref_supplier_key)->first();
            if($billingAddress || $shippingAddress){
                $contactDetails=Contact::where('ref_id', $request['supplier_id'])->where('ref_object_key',Address::$ref_supplier_key)->where('is_primary_contact',1)->first();
                $billingAddress= $billingAddress ? $billingAddress->full_address : NULL;
                $shippingAddress= $shippingAddress ? $shippingAddress->full_address : NULL;
                $display_name= isset($contactDetails->display_name) ? $contactDetails->display_name : NULL;
                $company_name= isset($contactDetails->company_name) ? $contactDetails->company_name : NULL;
            
                $purchaseAddressData=[
                    'supplier_id' =>$request['supplier_id'],
                    'purchase_id' =>$purchase->id,
                    'display_name' => $display_name,
                    'company_name' =>$company_name,
                    'billing_address' =>$billingAddress,
                    'shipping_address' =>$shippingAddress,
                ];

                $createPurchaseAddress=PurchaseAddress::create($purchaseAddressData);
            }
        }
        return $purchase;
    }

    public function update($request, $purchase){

        try {
            $updatePurchaseData = [
                'supplier_id' => isset($request['supplier_id']) ? $request['supplier_id'] : $purchase->supplier_id,
                'warehouse_id' =>isset($request['warehouse_id']) ? $request['warehouse_id'] : $purchase->warehouse_id,
                'invoice_no' => isset($request['invoice_no']) ? $request['invoice_no'] :  $purchase->invoice_no,
                'reference' => isset($request['reference']) ? $request['reference'] :  $purchase->reference,
                'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : $purchase->total_amount,
                'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : $purchase->due_amount,
                'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : $purchase->paid_amount,
                'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : $purchase->grand_total_amount,
                'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : $purchase->order_discount,
                'discount_currency' => isset($request['discount_currency']) ? $request['discount_currency'] : $purchase->discount_currency,
                'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : $purchase->order_tax,
                'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : $purchase->shipping_charge,
                'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : $purchase->order_adjustment,
                'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : $purchase->last_paid_amount,
                'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] :  $purchase->adjustment_text,
                'purchase_date' => isset($request['purchase_date']) ? $request['purchase_date'] :  $purchase->purchase_date,
                'delivery_date' => isset($request['delivery_date']) ? $request['delivery_date'] :  $purchase->delivery_date,
                'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] :  $purchase->attachment_file,
                'image' => isset($request['image']) ? $request['image'] :  $purchase->image,
                'status' => isset($request['status']) ? $request['status'] : $purchase->status,
                // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',
    
            ];
            $update = $purchase->update($updatePurchaseData);

            if($update){
                $purchaseAddress=PurchaseAddress::where('purchase_id',$purchase->id)->first();
               
                if($purchaseAddress){
                    $billingAddressId=isset($request['bill_address']) ? $request['bill_address'] : NULL;
                    $shippingAddressId=isset($request['ship_address']) ? $request['ship_address'] : NULL;
                    $billingAddress=Address::where('id',$billingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key',Address::$ref_supplier_key)->first();
                    $shippingAddress=Address::where('id',$shippingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key',Address::$ref_supplier_key)->first();
                    if($billingAddress || $shippingAddress){
                        
                        $contactDetails=Contact::where('ref_id', $request['supplier_id'])->where('ref_object_key',Address::$ref_supplier_key)->where('is_primary_contact',1)->first();
                        $billingAddress= $billingAddress ? $billingAddress->full_address : NULL;
                        $shippingAddress= $shippingAddress ? $shippingAddress->full_address : NULL;
                        $display_name= isset($contactDetails->display_name) ? $contactDetails->display_name : NULL;
                        $company_name= isset($contactDetails->company_name) ? $contactDetails->company_name : NULL;
                    
                        $purchaseAddressData=[
                            'supplier_id' =>$request['supplier_id'],
                            'purchase_id' =>$purchase->id,
                            'display_name' => $display_name,
                            'company_name' =>$company_name,
                            'billing_address' =>$billingAddress,
                            'shipping_address' =>$shippingAddress,
                        ];
        
                        $updatePurchaseAddress=$purchase->update($purchaseAddressData);
                         
                    } 
                }
                
            }
            return $purchase;
            
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
       
        
    }
}
