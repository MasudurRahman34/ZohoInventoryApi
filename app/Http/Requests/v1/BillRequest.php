<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "supplier_id" => 'required | integer|exists:portal_suppliers,id',
            "supplier_name" => 'nullable | regex:/^[\pL\s]+$/u',
            "shipping_address" => 'nullable | string | between: 5,512',
            "billing_address" => 'nullable | string | between: 5,512',
            "bill_number" => ['nullable', 'between: 3,20'], //need to check if login 
            "order_number.*" => ['nullable', 'between: 3,20'], //need to check if login 

            "order_id.*" => 'nullable|string|between: 3,255',
            "bill_date" => 'nullable|date|date_format:Y-m-d',
            "due_date" => 'nullable|date|date_format:Y-m-d',

            "order_tax" => 'nullable|numeric|between:0,100',
            "order_tax_amount" => 'nullable|numeric|between:0,9999999999.9999',
            "discount_type" => 'nullable|numeric|min:0',

            "order_discount" => 'nullable|numeric|between:0,100',
            "shipping_charge" => 'nullable|numeric|between:0,9999999999.9999',
            "order_adjustment" => 'nullable|numeric|between:-9999999999.9999,9999999999.9999',
            "total_amount" => 'required|numeric|between:0,9999999999.9999',
            "total_tax" => 'nullable|numeric|between:0,9999999999.9999',
            "grand_total_amount" => 'required|numeric|between:0,9999999999.9999',
            "paid_amount" => 'nullable|numeric|min:0|lte:grand_total_amount',
            "balance" => 'required_with:paid_amount|nullable|numeric|lte:grand_total_amount',
            "due_amount" => 'nullable|numeric|min:0|lte:grand_total_amount',
            "change_amount" => 'nullable|numeric|min:0|lte:grand_total_amount',
            "last_paid" => 'nullable|numeric|min:0|lte:grand_total_amount',
            "adjustment_text" => 'string|between:3,255|nullable',
            "bill_terms" => 'string|min:3|nullable',
            "bill_description" => 'string|min:3|nullable',
            "bill_type" => 'string|min:3|nullable',
            "bill_currency" => 'string|min:3|nullable',
            "status" => 'in:0,1,2,3,4,5,6|nullable',


            'billItems.*.bill_id' => 'bill_id|integer|exists:bills,id|nullable',
            // 'billItems.*.product_id' => 'nullable|integer|exists:products,id|distinct', //should check exists with product table //must not duplicate
            'billItems.*.product_name' => 'string|between:3,255|nullable',
            'billItems.*.warehouse_id' => 'nullable|integer|exists:warehouses,id',
            'billItems.*.serial_number' => 'nullable|string|between:3,20',
            'billItems.*.product_description' => 'nullable|string|min:3',
            'billItems.*.order_number' => 'nullable|string|between:3,20',

            'billItems.*.product_qty' => 'required|integer|between:1,9999999999.99',
            'billItems.*.unit_price' => 'required|numeric|between:1,9999999999.99',
            'billItems.*.product_discount' => 'nullable|numeric|lte:billItems.*.unit_price',
            'billItems.*.tax_name' => 'nullable|regex:/^[\pL\s]+$/u|between:3,20',
            'billItems.*.tax_rate' => 'nullable|numeric|between:0,100',
            'billItems.*.tax_amount' => 'nullable|numeric|between:0,9999999999.9999',
            'billItems.*.whole_price' => 'nullable|numeric|between:0,9999999999.9999',
            'billItems.*.subtotal' => 'required|numeric|between:0,9999999999.9999',
            // 'billItems.*.product_tax' => 'numeric|min:0|nullable', //tax can be greater than unit price e.g car

            'billItems.*.is_serialized' => 'nullable|integer|in:0,1',
            'billItems.*.is_taxable' => 'nullable|integer|in:0,1',
            'billItems.*.status' => 'nullable|integer|in:0,1',
        ];
    }
}
