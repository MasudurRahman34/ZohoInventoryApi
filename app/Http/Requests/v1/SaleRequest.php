<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class SaleRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|integer|exists:portal_customers,id',
            'warehouse_id' => 'required|integer|min:0',
            'order_number' => 'required|string|between:3,50',
            'sales_order_date'=> 'required|date|date_format:Y-m-d H:i:s',
            'expected_shipment_date'=> 'date|date_format:Y-m-d|after_or_equal:sales_order_date|nullable',
            'billing_address' => 'string|nullable',
            'billing_address' => 'string|nullable',
            'delivery_method'=> 'string|between:3,255|nullable',
            'reference'=> 'string|between:3,50|nullable',
            'order_discount'=> 'numeric|min:0|nullable|lte:total_amount',
            'discount_currency'=> 'integer|min:0|nullable',
            'order_discount_amount'=> 'numeric|min:0|lte:total_amount|nullable',
            'order_tax'=> 'integer|min:0|lte:total_amount|nullable',
            'order_tax_amount'=> 'numeric|min:0|lte:total_amount|nullable',
            'shipping_charge'=> 'numeric|min:0|lte:total_amount|nullable',
            'order_adjustment'=> 'numeric|min:0|lte:total_amount|nullable',
            'adjustment_text'=> 'string|nullable',
            'customer_note'=> 'string|nullable',
            'terms_condition'=> 'string|nullable',
            'total_amount'=> 'required|numeric|min:0|',
            'grand_total_amount'=> 'required|numeric|min:0|lte:total_amount',
            'due_amount'=> 'required|numeric|min:0|lte:grand_total_amount',
            'paid_amount'=> 'required|numeric|min:0|lte:grand_total_amount',
            'recieved_amount'=> 'numeric|min:0|lte:grand_total_amount|nullable',
            'changed_amount'=> 'numeric|min:0|nullable|lte:grand_total_amount',
            'last_paid_amount'=> 'numeric|min:0|lte:grand_total_amount|nullable',
            'offer_to'=>'string|between:3,512|nullable',
            'offer_subject'=>'string|between:3,512|nullable',
            'offer_terms_condition'=>'string|nullable|between:3,512',
            'invoice_status'=> 'integer|in:0,1',
            'shipment_status'=> 'integer|in:0,1',
            'payment_status'=> 'integer|in:0,1,2',
            'status'=> 'integer|in:0,1,2', 
            'sales_type'=> 'integer|in:0,1',
            
            'saleitems.*.product_id'=>'required|numeric|min:0', //need to check exsist with product table
            'saleitems.*.serial_number'=>'string|nullable|between:3,100',
            'saleitems.*.product_qty'=>'required|integer|min:1',          
            'saleitems.*.packed_qty'=>'integer|min:0|nullable',
            'saleitems.*.shipped_qty'=>'integer|min:0|nullable',
            'saleitems.*.invoice_qty'=>'integer|min:0|nullable',
            'saleitems.*.unit_price'=>'required|numeric|min:0',
            'saleitems.*.product_discount'=>'numeric|min:0|nullable',
            'saleitems.*.product_tax'=>'numeric|min:0|nullable',
            'saleitems.*.subtotal'=>'required|numeric|min:0',
            'saleitems.*.description'=>'string|nullable',
            'saleitems.*.is_serialized'=>'integer|in:0,1',
        ];
    }
    public function failedValidation(Validator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
