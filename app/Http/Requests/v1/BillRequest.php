<?php

namespace App\Http\Requests\v1;

use App\Enums\V1\BillEnum;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BillRequest extends FormRequest
{
    use ApiResponse;
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

            "order_discount" => 'nullable|numeric|between:0,100',
            "discount_amount" => 'nullable|numeric|between:0,9999999999.9999',
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
            "bill_type" => 'integer|nullable',
            "bill_currency" => 'string|min:3|nullable',
            "status" => ['required', new Enum(BillEnum::class)],


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

            //sender address 
            'sender.display_name' => 'string|nullable',
            'sender.company_name' => 'required | regex:/^[a-zA-Z0-9@ ]+$/, between:3,255',
            'sender.company_info' => 'string|nullable',
            'sender.company_logo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|nullable',
            'sender.attention' => 'string|nullable',
            "sender.first_name" => 'nullable | regex:/^[\pL\s]+$/u',
            "sender.last_name" => 'nullable | regex:/^[\pL\s]+$/u',
            "sender.mobile" => 'required_without:sender.email | digits_between:7,15',
            "sender.mobile_country_code" => ['nullable', 'regex:/^\+\d{1,3}$/', 'between:2,6'],
            "sender.email" => ['nullable', 'email:rfc,filter,dns', 'max:255'],
            'sender.house' => 'string|between:3,255|nullable',
            'sender.phone' => 'digits_between:7,11|nullable',
            'sender.fax' => 'string|between:5,20|nullable',

            'sender.country_id' => 'integer|exists:countries,id|nullable',
            // 'sender.country_id' => 'integer|nullable|digits_between:1,4',
            'sender.country_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'sender.state_name' => ['string', 'regex:/^[\pL\s]+$/u', 'between:2,50', 'nullable'],
            'sender.district_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'sender.thana_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'sender.union_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'sender.zipcode' => 'integer|nullable|digits_between:2,10',
            'sender.street_address_line_1' => 'string|nullable', //'regex:/([- ,\/0-9a-zA-Z]+)/' including ,/-
            'sender.street_address_line_1' => 'string|nullable',
            'sender.status' => 'integer|in:0,1|nullable', //0=invalid, 1=valid



            // //reciever address
            'receiver.display_name' => 'string|nullable',
            'receiver.company_name' => 'required | regex:/^[a-zA-Z0-9@ ]+$/, between:3,255',
            'receiver.company_info' => 'string|nullable',
            'receiver.company_logo' => 'image|nullable',
            'receiver.attention' => 'string|nullable',
            "receiver.first_name" => 'nullable | regex:/^[\pL\s]+$/u',
            "receiver.last_name" => 'nullable | regex:/^[\pL\s]+$/u',
            "receiver.mobile" => 'required_without:receiver.email|nullable | digits_between:7,15',
            "receiver.mobile_country_code" => ['nullable', 'regex:/^\+\d{1,3}$/', 'between:2,6'],
            "receiver.email" => ['nullable', 'email:rfc,filter,dns', 'max:255'],
            'receiver.house' => 'string|between:3,255|nullable',
            'receiver.phone' => 'digits_between:7,11|nullable',
            'receiver.fax' => 'string|between:5,20|nullable',

            'receiver.country_id' => 'integer|exists:countries,id|nullable',
            // 'receiver.country_id' => 'integer|nullable|digits_between:1,4',
            'receiver.country_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'receiver.state_name' => ['string', 'regex:/^[\pL\s]+$/u', 'between:2,50', 'nullable'],
            'receiver.district_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'receiver.thana_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'receiver.union_name' => 'string|regex:/^[\pL\s]+$/u|between:2,50|nullable',
            'receiver.zipcode' => 'integer|nullable|digits_between:2,10',
            'receiver.street_address_line_1' => 'string|nullable', //'regex:/([- ,\/0-9a-zA-Z]+)/' including ,/-
            'receiver.street_address_line_1' => 'string|nullable',
            'receiver.status' => 'integer|in:0,1|nullable'
        ];
    }
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(

            $this->error($validator->errors(), 422)

        );
    }
}
