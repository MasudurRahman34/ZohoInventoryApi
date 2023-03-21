<?php

namespace App\Http\Services\V1;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\PurchaseAddress;
use App\Models\Supplier;
use App\Models\Warehouse;

use function PHPUnit\Framework\throwException;

class PurchaseService
{
    protected $addressService;
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }


    public function store($request)
    {
        //return $request['grand_total_amount'];
        $purchaseData = [
            'supplier_id' => $request['supplier_id'],
            'supplier_name' => isset($request['supplier_name']) ? $request['supplier_name'] : NULL,
            'warehouse_id' => $request['warehouse_id'],
            // 'invoice_no' => isset($request['invoice_no']) ? $request['invoice_no'] : NULL,
            'purchase_number' => isset($request['purchase_number']) ? $request['purchase_number'] : NULL,
            'total_tax' => isset($request['total_tax']) ? $request['total_tax'] : 0,
            'total_whole_amount' => isset($request['total_whole_amount']) ? $request['total_whole_amount'] : 0,
            'total_product_discount' => isset($request['total_product_discount']) ? $request['total_product_discount'] : 0,
            'balance' => isset($request['balance']) ? $request['balance'] : 0,
            'order_tax_amount' => isset($request['order_tax_amount']) ? $request['order_tax_amount'] : 0,
            'purchase_terms' => isset($request['purchase_terms']) ? $request['purchase_terms'] : null,
            'purchase_description' => isset($request['purchase_description']) ? $request['purchase_description'] : null,
            'purchase_type' => isset($request['purchase_type']) ? $request['purchase_type'] : null,
            'purchase_currency' => isset($request['purchase_currency']) ? $request['purchase_currency'] : null,
            'pdf_link' => isset($request['pdf_link']) ? $request['pdf_link'] : null,

            'reference' => isset($request['reference']) ? $request['reference'] : NULL,
            'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
            'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
            'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
            'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
            'discount_amount' => isset($request['discount_amount']) ? $request['discount_amount'] : 0,
            'discount_percentage' => isset($request['discount_percentage']) ? $request['discount_percentage'] : 0,
            'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,

            'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
            'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
            'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,
            'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
            'purchase_date' => isset($request['purchase_date']) ? $request['purchase_date'] : NULL,
            'delivery_date' => isset($request['delivery_date']) ? $request['delivery_date'] : NULL,
            'payment_term' => isset($request['payment_term']) ? $request['payment_term'] : null,
            // 'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] : NULL,
            // 'image' => isset($request['image']) ? $request['image'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : 0,
            // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

        ];

        $purchase = Purchase::create($purchaseData);

        if ($purchase) {
            // $billingAddressId = isset($request['bill_address']) ? $request['bill_address'] : NULL;
            // $shippingAddressId = isset($request['ship_address']) ? $request['ship_address'] : NULL;
            // $billingAddress = Address::where('id', $billingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key', Address::$ref_supplier_key)->first();
            // $shippingAddress = Address::where('id', $shippingAddressId)->where('ref_id', $request['supplier_id'])->where('ref_object_key', Address::$ref_supplier_key)->first();
            // if ($billingAddress || $shippingAddress) {
            //     $contactDetails = Contact::where('ref_id', $request['supplier_id'])->where('ref_object_key', Address::$ref_supplier_key)->where('is_primary_contact', 1)->first();
            //     $billingAddress = $billingAddress ? $billingAddress->full_address : NULL;
            //     $shippingAddress = $shippingAddress ? $shippingAddress->full_address : NULL;
            //     $display_name = isset($contactDetails->display_name) ? $contactDetails->display_name : NULL;
            //     $company_name = isset($contactDetails->company_name) ? $contactDetails->company_name : NULL;

            //     $purchaseAddressData = [
            //         'supplier_id' => $request['supplier_id'],
            //         'purchase_id' => $purchase->id,
            //         'display_name' => $display_name,
            //         'company_name' => $company_name,
            //         'billing_address' => $billingAddress,
            //         'shipping_address' => $shippingAddress,
            //     ];

            //     $createPurchaseAddress = PurchaseAddress::create($purchaseAddressData);
            // }

            if (isset($request['supplierAddress'])) {
                if (\is_array($request['supplierAddress'])) {

                    foreach ($request['supplierAddress'] as $key => $addressId) {
                        $this->storePurchaseAddressById($addressId, $key, $purchase, Supplier::class, $request['supplier_id'], $request['deliver_to']);
                    }
                }
            }

            if (isset($request['warehouseAddress'])) {
                if (\is_array($request['warehouseAddress'])) {
                    foreach ($request['warehouseAddress'] as $key => $addressId) {
                        $this->storePurchaseAddressById($addressId, $key, $purchase, Warehouse::class, $request['warehouse_id'], $request['deliver_to']);
                    }
                }
            }

            if (isset($request['customerAddress'])) {
                if (\is_array($request['customerAddress'])) {
                    foreach ($request['customerAddress'] as $key => $addressId) {
                        $this->storePurchaseAddressById($addressId, $key, $purchase, Customer::class, $request['customer_id'], $request['deliver_to']);
                    }
                }
            }
        }
        return $purchase;
    }


    public function storePurchaseAddressById($addressId, $type, $purchase, $addressableType, $addressableId, $deliverTo)
    {
        $address = Address::find($addressId);
        if ($address) {
            $purchaseAddressData = $this->makeAddressValueFromFullAddress($address);
            $purchaseAddressData['addressable_id'] = $addressableId;
            $purchaseAddressData['purchase_id'] = $purchase->id;
            $purchaseAddressData['addressable_type'] = $addressableType;
            $purchaseAddressData['attention'] = $address->attention;
            $purchaseAddressData['full_address'] = $address->full_address;
            $purchaseAddressData['plain_address'] = $this->addressService->setPlainAddress($address->full_address);
            $purchaseAddressData['deliver_to'] = $deliverTo;
            $purchaseAddressData['type'] = $type;

            $newPurchaseAddress = PurchaseAddress::create($purchaseAddressData);
        }
    }





    public function update($request, $purchase)
    {

        try {
            $updatePurchaseData = [
                'supplier_id' => isset($request['supplier_id']) ? $request['supplier_id'] : $purchase->supplier_id,
                'supplier_name' => isset($request['supplier_name']) ? $request['supplier_name'] : $purchase->supplier_name,
                'warehouse_id' => isset($request['warehouse_id']) ? $request['warehouse_id'] : $purchase->warehouse_id,
                'purchase_number' => isset($request['purchase_number']) ? $request['purchase_number'] :  $purchase->purchase_number,

                'total_tax' => isset($request['total_tax']) ? $request['total_tax'] : $purchase->total_tax,
                'total_whole_amount' => isset($request['total_whole_amount']) ? $request['total_whole_amount'] : $purchase->total_whole_amount,
                'total_product_discount' => isset($request['total_product_discount']) ? $request['total_product_discount'] : $purchase->total_product_discount,
                'balance' => isset($request['balance']) ? $request['balance'] : $purchase->balance,
                'order_tax_amount' => isset($request['order_tax_amount']) ? $request['order_tax_amount'] : $purchase->order_tax_amount,
                'purchase_terms' => isset($request['purchase_terms']) ? $request['purchase_terms'] : $purchase->purchase_terms,
                'purchase_description' => isset($request['purchase_description']) ? $request['purchase_description'] : $purchase->purchase_description,
                'purchase_type' => isset($request['purchase_type']) ? $request['purchase_type'] : $purchase->purchase_type,
                'purchase_currency' => isset($request['purchase_currency']) ? $request['purchase_currency'] : $purchase->purchase_currency,
                'pdf_link' => isset($request['pdf_link']) ? $request['pdf_link'] : $purchase->pdf_link,
                'payment_term' => isset($request['payment_term']) ? $request['payment_term'] : $purchase->payment_term,

                'reference' => isset($request['reference']) ? $request['reference'] :  $purchase->reference,
                'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : $purchase->total_amount,
                'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : $purchase->due_amount,
                'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : $purchase->paid_amount,
                'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : $purchase->grand_total_amount,
                'discount_amount' => isset($request['discount_amount']) ? $request['discount_amount'] : $purchase->discount_amount,
                'discount_percentage' => isset($request['discount_percentage']) ? $request['discount_percentage'] : $purchase->discount_currency,
                'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : $purchase->order_tax,
                'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : $purchase->shipping_charge,
                'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : $purchase->order_adjustment,
                'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : $purchase->last_paid_amount,
                'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] :  $purchase->adjustment_text,
                'purchase_date' => isset($request['purchase_date']) ? $request['purchase_date'] :  $purchase->purchase_date,
                'delivery_date' => isset($request['delivery_date']) ? $request['delivery_date'] :  $purchase->delivery_date,
                // 'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] :  $purchase->attachment_file,
                // 'image' => isset($request['image']) ? $request['image'] :  $purchase->image,
                'status' => isset($request['status']) ? $request['status'] : $purchase->status,
                'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : $purchase->payment_status,

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


    public function makeAddressValueFromFullAddress($address)
    {
        $addressData = [];
        if (!is_null($address->full_address)) {
            $addressData['country_name'] = isset($address->full_address['country']['country_name']) ? $address->full_address['country']['country_name'] : \null;
            $addressData['country_id'] = isset($address->full_address['country']['id']) ? $address->full_address['country']['id'] : \null;
            $addressData['state_name'] = isset($address->full_address['state']['state_name']) ? $address->full_address['state']['state_name'] : \null;
            $addressData['district_name'] = isset($address->full_address['district']['district_name']) ? $address->full_address['district']['district_name'] : \null;
            $addressData['thana_name'] = isset($address->full_address['thana']['thana_name']) ? $address->full_address['thana']['thana_name'] : \null;
            $addressData['union_name'] = isset($address->full_address['union']['union_name']) ? $address->full_address['union']['union_name'] : \null;
            $addressData['zipcode'] = isset($address->full_address['zipcode']['zip_code']) ? $address->full_address['zipcode']['zip_code'] : \null;
            $addressData['street_address_line_1'] = isset($address->full_address['street_address']['street_address_value']) ? $address->full_address['street_address']['street_address_value'] : \null;
        }

        return $addressData;
    }
}
