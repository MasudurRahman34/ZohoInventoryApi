<?php
namespace App\Http\Services\V1;

use App\Models\Supplier;

class SupplierService{


    public function store($request){
        $supplierData = [
            'supplier_number' => $request['supplier_number'],
            'supplier_type' => isset($request['supplier_type']) ? $request['supplier_type'] : 1,
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
        $supplier = supplier::create($supplierData);
        return $supplier;
}

    public function update($request, $supplier){

         $supplierData = [
            'supplier_number' => isset($request['supplier_number']) ? $request['supplier_number'] : $supplier->supplier_number,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : $supplier->display_name,
            'supplier_type' => isset($request['supplier_type']) ? $request['supplier_type'] : $supplier->supplier_type,
            'copy_bill_address' => isset($request['copy_bill_address']) ? $request['copy_bill_address'] : $supplier->copy_bill_address,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : $supplier->company_name,
            'website' => isset($request['website']) ? $request['website'] : $supplier->website,
            'tax_rate' => isset($request['tax_rate']) ? $request['tax_rate'] : $supplier->tax_rate,
            'currency' => isset($request['currency']) ? $request['currency'] : $supplier->currency,
            'image' => isset($request['image']) ? $request['image'] : $supplier->image,
            'payment_terms' => isset($request['payment_terms']) ? $request['payment_terms'] : $supplier->payment_terms,
            ];
            $unpdatedSupplier= $supplier->update($supplierData);
            return $supplier;
        
    }
}
