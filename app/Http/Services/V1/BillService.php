<?php

namespace App\Http\Services\V1;

use App\Models\Address;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Contact;
use App\Models\Purchase;
use App\Models\PurchaseAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\throwException;

class BillService
{


    public function store($request)
    {
        //return $request['grand_total_amount'];
        $newBillrequest = [
            'supplier_id' => isset($request['supplier_id']) ? $request['supplier_id'] : NULL,
            'supplier_name' => isset($request['supplier_name']) ? $request['supplier_name'] : NULL,
            'shipping_address' => isset($request['shipping_address']) ? $request['shipping_address'] : NULL,
            'billing_address' => isset($request['billing_address']) ? $request['billing_address'] : NULL,

            'bill_number' => isset($request['bill_number']) ? $request['bill_number'] : NULL,
            'short_code' => $this->generateShorCode('bills', 'short_code', 6), //generate from system
            'order_id' => isset($request['order_id']) ? $request['order_id'] : NULL,
            'order_number' => isset($request['order_number']) ? $request['order_number'] : NULL,
            'bill_date' => isset($request['bill_date']) ? $request['bill_date'] : Carbon::now(),
            'due_date' => isset($request['due_date']) ? $request['due_date'] : NULL,

            'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,
            'order_tax_amount' => isset($request['order_tax_amount']) ? $request['order_tax_amount'] : 0,
            'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : 0,
            'discount_type' => isset($request['discount_type']) ? $request['discount_type'] : 0,
            'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
            'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
            'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
            'total_whole_amount' => isset($request['total_whole_amount']) ? $request['total_whole_amount'] : 0,
            'total_tax' => isset($request['total_tax']) ? $request['total_tax'] : 0,
            'total_product_discount' => isset($request['total_product_discount']) ? $request['total_product_discount'] : 0,
            'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
            'balance' => isset($request['balance']) ? $request['balance'] : 0,
            'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
            'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
            // 'recieved_amount' => isset($request['recieved_amount']) ? $request['recieved_amount'] : 0,
            'changed_amount' => isset($request['changed_amount']) ? $request['changed_amount'] : 0,
            'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,

            'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
            'bill_terms' => isset($request['bill_terms']) ? $request['bill_terms'] : NULL,
            'bill_description' => isset($request['bill_description']) ? $request['bill_description'] : NULL,

            'bill_type' => isset($request['bill_type']) ? $request['bill_type'] : NULL,
            'bill_currency' => isset($request['bill_currency']) ? $request['bill_currency'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : 0,
            'user_ip' => isset($request['user_ip']) ? $request['user_ip'] : NULL,
            'payment_term' => isset($request['payment_term']) ? $request['payment_term'] : NULL,
            // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

        ];
        $newBill = Bill::create($newBillrequest);

        if ($newBill) {
            if (isset($request['billItems'])) {
                if (count($request['billItems']) > 0) {
                    foreach ($request['billItems'] as $item) {

                        $this->storeBillItem($item, $newBill);
                    }
                }
            }
        }
        return $newBill;
    }

    public function storeBillItem($item, $newBill) //store invoice item
    {
        $newBillItemRequest = [
            'bill_id' => $newBill->id,
            'service_date' => isset($item['service_date']) ? $item['service_date'] : NULL,
            'product_id' => isset($item['product_id']) ? $item['product_id'] : NULL,
            'warehouse_id' => isset($item['warehouse_id']) ? $item['warehouse_id'] : NUll,
            'order_id' => isset($item['order_id']) ? $item['order_id'] : NULL,
            'product_name' => isset($item['product_name']) ? $item['product_name'] : NULL,
            'serial_number' => isset($item['serial_number']) ? $item['serial_number'] : NULL,
            'group_number' => isset($item['group_number']) ? $item['group_number'] : NULL,

            'product_description' => isset($item['product_description']) ? $item['product_description'] : NULL,
            'order_number' => isset($item['order_number']) ? $item['order_number'] : NULL,
            'product_qty' => isset($item['product_qty']) ? $item['product_qty'] : NULL,

            'unit_price' => isset($item['unit_price']) ? $item['unit_price'] : 0,
            'product_discount' => isset($item['product_discount']) ? $item['product_discount'] : 0,
            'tax_name' => isset($item['tax_name']) ? $item['tax_name'] : 0,
            'tax_rate' => isset($item['tax_rate']) ? $item['tax_rate'] : 0,
            'tax_amount' => isset($item['tax_amount']) ? $item['tax_amount'] : 0,
            'whole_price' => isset($item['whole_price']) ? $item['whole_price'] : 0,
            'subtotal' => isset($item['subtotal']) ? $item['subtotal'] : 0,
            'total_tax' => isset($item['total_amount']) ? $item['total_tax'] : 0,
            'is_taxable' => isset($item['is_taxable']) ? $item['is_taxable'] : 0,
            'is_serialized' => isset($item['is_serialized']) ? $item['is_serialized'] : 0,

        ];
        $newBillItem = BillItem::create($newBillItemRequest);
        return $newBillItem;
    }

    public function update($request, $purchase)
    {

        try {
            $updatePurchaseData = [
                'supplier_id' => isset($request['supplier_id']) ? $request['supplier_id'] : $purchase->supplier_id,
                'warehouse_id' => isset($request['warehouse_id']) ? $request['warehouse_id'] : $purchase->warehouse_id,
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

            if ($update) {
                $purchaseAddress = PurchaseAddress::where('purchase_id', $purchase->id)->first();

                if ($purchaseAddress) {
                    $billingAddressId = isset($request['bill_address']) ? $request['bill_address'] : NULL;
                    $shippingAddressId = isset($request['ship_address']) ? $request['ship_address'] : NULL;
                    $billingAddress = Address::where('id', $billingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key', Address::$ref_supplier_key)->first();
                    $shippingAddress = Address::where('id', $shippingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key', Address::$ref_supplier_key)->first();
                    if ($billingAddress || $shippingAddress) {

                        $contactDetails = Contact::where('ref_id', $request['supplier_id'])->where('ref_object_key', Address::$ref_supplier_key)->where('is_primary_contact', 1)->first();
                        $billingAddress = $billingAddress ? $billingAddress->full_address : NULL;
                        $shippingAddress = $shippingAddress ? $shippingAddress->full_address : NULL;
                        $display_name = isset($contactDetails->display_name) ? $contactDetails->display_name : NULL;
                        $company_name = isset($contactDetails->company_name) ? $contactDetails->company_name : NULL;

                        $purchaseAddressData = [
                            'supplier_id' => $request['supplier_id'],
                            'purchase_id' => $purchase->id,
                            'display_name' => $display_name,
                            'company_name' => $company_name,
                            'billing_address' => $billingAddress,
                            'shipping_address' => $shippingAddress,
                        ];

                        $updatePurchaseAddress = $purchase->update($purchaseAddressData);
                    }
                }
            }
            return $purchase;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function generateShorCode($table, $coloumn, $length_of_string): string  //generate shortcode
    {
        //for random string
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string = substr(str_shuffle($str_result), 0, $length_of_string);
        // $generateStringkey = date("Ymd") . '-' . $string;
        $isExistString =  DB::table($table)->where($coloumn, $string)->first();

        if ($isExistString) {
            return $this->generateShorCode($table, $coloumn, $length_of_string); //recurisuve if found generate new one
        } else {
            return strtolower($string);
        }
    }
}
