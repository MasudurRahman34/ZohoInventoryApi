<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class publicInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            //invoice validation
            "customer_id" => 'required_without:customer_name|integer|exists:portal_customers,id|nullable',
            "customer_name" => 'nullable | regex:/^[\pL\s]+$/u',
            "shipping_address" => 'nullable | string | between: 5,512',
            "billing_address" => 'nullable | string | between: 5,512',
            "invoice_number.*" => ['required', 'between: 3,20'], //need to check if login 

            "order_id.*" => 'nullable|string|between: 3,255',
            "invoice_date" => 'nullable|date|date_format:Y-m-d H:i:s,Y-m-d',
            "due_date" => 'nullable|date|date_format:Y-m-d H:i:s,Y-m-d',

            "order_tax" => 'nullable|numeric|min:0',
            "order_tax_amount" => 'nullable|numeric|min:0',
            "discount_type" => 'nullable|numeric|min:0',

            "order_discount" => 'nullable|required|numeric|min:0',
            "shipping_charge" => 'nullable|required|numeric|min:0',
            "order_adjustment" => 'nullable|required|numeric|min:0',
            "total_amount" => 'required|numeric|min:0',
            "total_tax" => 'required|numeric|min:0',
            "grand_total_amount" => 'required|numeric|min:0',
            "paid_amount" => 'nullable|numeric|min:0|lte:grand_total_amount',
            "balance" => 'required_with:paid_amount|nullable|numeric|min:0',
            // "due_amount" => 'nullable|numeric|min:0',
            // "change_amount" => 'nullable|numeric|min:0',
            // "last_paid" => 'nullable|numeric|min:0',
            "adjustment_text" => 'string|between:3,255|nullable',
            "invoice_terms" => 'string|min:3|nullable',
            "invoice_description" => 'string|min:3|nullable',
            "invoice_type" => 'string|min:3|nullable',
            "invoice_currency" => 'string|min:3|nullable',
            "status" => 'required|in:0,1,2,3,4,5,6|nullable',

            // invoice item validation

            'invoiceItems.*.invoice_id' => 'invoice_id|integer|exists:invoices,id|nullable',
            // 'invoiceItems.*.product_id' => 'nullable|integer|exists:products,id|distinct', //should check exists with product table //must not duplicate
            'invoiceItems.*.product_name' => 'string|between:3,255|nullable',
            'invoiceItems.*.warehouse_id' => 'nullable|integer|exists:warehouses,id',
            'invoiceItems.*.serial_number' => 'nullable|string|between:3,20',
            'invoiceItems.*.product_description' => 'nullable|string|min:3',
            'invoiceItems.*.order_number' => 'nullable|string|between:3,20',

            'invoiceItems.*.product_qty' => 'required|integer|min:1',
            'invoiceItems.*.unit_price' => 'required|numeric|min:0',
            'invoiceItems.*.product_discount' => 'nullable|numeric|min:0',
            'invoiceItems.*.tax_name' => 'nullable|regex:/^[\pL\s]+$/u|between:3,20',
            'invoiceItems.*.rate' => 'nullable|numeric|min:0',
            'invoiceItems.*.tax_amount' => 'nullable|numeric|min:0',
            'invoiceItems.*.whole_price' => 'nullable|numeric|min:0',
            'invoiceItems.*.subtotal' => 'required|numeric|min:0',
            // 'invoiceItems.*.product_tax' => 'numeric|min:0|nullable', //tax can be greater than unit price e.g car

            'invoiceItems.*.is_serialized' => 'nullable|integer|in:0,1',
            'invoiceItems.*.is_taxable' => 'nullable|integer|in:0,1',
            'invoiceItems.*.status' => 'nullable|integer|in:0,1',



            //sender address 
            //     'sender.display_name' => 'string|nullable',
            //     'sender.company_name' => 'required | regex:/^[a-zA-Z0-9@ ]+$/, between:3,255',
            //     'sender.company_info' => 'string|nullable',
            //     'sender.company_logo' => 'image|nullable',
            //     'sender.attention' => 'string|nullable',
            //     "sender.first_name" => 'nullable | regex:/^[\pL\s]+$/u',
            //     "sender.last_name" => 'nullable | regex:/^[\pL\s]+$/u',
            //     "sender.mobile" => 'nullable | digits_between:7,15',
            //     "sender.mobile_country_code" => ['nullable', 'regex:/^\+\d{1,3}$/', 'between:2,6'],
            //     "sender.email" => ['nullable', 'email:rfc,filter,dns', 'max:255'],
            //     'sender.house' => 'string|between:5,255|nullable',
            //     'sender.phone' => 'digits_between:7,11|nullable',
            //     'sender.fax' => 'string|between:5,20|nullable',
            //     'sender.country_id' => 'integer|exists:countries,id|nullable',
            //     'sender.state_id' => 'integer|exists:states,id|nullable',
            //     'sender.district_id' => 'integer|exists:districts,id|nullable',
            //     'sender.thana_id' => 'integer|exists:thanas,id|nullable',
            //     'sender.union_id' => 'integer|exists:unions,id|nullable',
            //     'sender.zipcode' => 'integer|exists:zipcodes,id|nullable',
            //     'sender.street_address_id' => 'integer|exists:street_addresses,id|nullable',
            //     'sender.status' => 'integer|in:0,1|nullable', //0=invalid, 1=valid



            //     // //reciever address

            //     'reciever.display_name' => 'string|nullable',
            //     'reciever.company_name' => 'required | regex:/^[a-zA-Z0-9@ ]+$/, between:3,255',
            //     'reciever.company_info' => 'string|nullable',
            //     'reciever.company_logo' => 'image|file|size:200|nullable',
            //     'reciever.attention' => 'string|nullable',
            //     "reciever.first_name" => 'nullable | regex:/^[\pL\s]+$/u',
            //     "reciever.last_name" => 'nullable | regex:/^[\pL\s]+$/u',
            //     "reciever.mobile" => 'nullable | digits_between:7,15|nullable',
            //     "reciever.mobile_country_code" => ['nullable', 'regex:/^\+\d{1,3}$/', 'between:2,6'],
            //     "reciever.email" => ['required', 'email:rfc,filter,dns', 'max:255'],
            //     'reciever.house' => 'string|between:5,255|nullable',
            //     'reciever.phone' => 'digits_between:7,11|nullable',
            //     'reciever.fax' => 'string|between:5,20|nullable',
            //     'reciever.country_id' => 'integer|exists:countries,id|nullable',
            //     'reciever.state_id' => 'integer|exists:states,id|nullable',
            //     'reciever.district_id' => 'integer|exists:districts,id|nullable',
            //     'reciever.thana_id' => 'integer|exists:thanas,id|nullable',
            //     'reciever.union_id' => 'integer|exists:unions,id|nullable',
            //     'reciever.zipcode' => 'string|exists:zipcodes,id|nullable',
            //     'reciever.street_address_id' => 'integer|exists:street_addresses,id|nullable',
            //     'reciever.status' => 'integer|in:0,1|nullable', //0=invalid, 1=valid
            // ];
        ];
    }
}
