<?php
namespace App\Http\Services\V1;

use App\Models\Customer;

class CustomerService{


    public function store($request){
        $customerData = [
            'customer_number' => $request['customer_number'],
            'customer_type' => isset($request['customer_type']) ? $request['customer_type'] : 1,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : null,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : null,
            'website' => isset($request['website']) ? $request['website'] : null,
            'tax_name' => isset($request['tax_name']) ? $request['tax_name'] : 0,
            'tax_rate' => isset($request['tax_rate']) ? $request['tax_rate'] : 0,
            'currency' => isset($request['currency']) ? $request['currency'] : 0,
            'image' => isset($request['image']) ? $request['image'] : null,
            'payment_terms' => isset($request['payment_terms']) ? $request['payment_terms'] : 0,
            'copy_bill_address' => isset($request['copy_bill_address']) ? $request['copy_bill_address'] : 0,
        ];
        $customer = Customer::create($customerData);
        return $customer;
}

    public function update($request, $customer){

         $customerData = [
            'customer_number' => isset($request['customer_number']) ? $request['customer_number'] : $customer->customer_number,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : $customer->display_name,
            'customer_type' => isset($request['customer_type']) ? $request['customer_type'] : $customer->customer_type,
            'copy_bill_address' => isset($request['copy_bill_address']) ? $request['copy_bill_address'] : $customer->copy_bill_address,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : $customer->company_name,
            'website' => isset($request['website']) ? $request['website'] : $customer->website,
            'tax_rate' => isset($request['tax_rate']) ? $request['tax_rate'] : $customer->tax_rate,
            'currency' => isset($request['currency']) ? $request['currency'] : $customer->currency,
            'image' => isset($request['image']) ? $request['image'] : $customer->image,
            'payment_terms' => isset($request['payment_terms']) ? $request['payment_terms'] : $customer->payment_terms,
            ];
            $unpdatedcustomer= $customer->update($customerData);
            return $customer;
        
    }
}
