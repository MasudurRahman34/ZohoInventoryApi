<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends FormRequest
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
        $rules= [
            'supplier_id' => 'required|integer|exists:portal_suppliers,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id', //need to check with wareshouses table
            'invoice_no' => 'string|between:3,50|nullable',
            'reference' => 'string|between:3,50|nullable',
            'total_amount'=> 'required|numeric|min:0',
            'due_amount'=> 'numeric|min:0|lte:grand_total_amount',
            'paid_amount'=> 'numeric|min:0|lte:grand_total_amount',
            'grand_total_amount'=> 'required|numeric|min:0',
            'order_discount'=> 'numeric|min:0|max:100|nullable|',
            'discount_currency'=> 'integer|min:0|nullable',
            'order_tax'=> 'integer|min:0|lte:total_amount|nullable',
            'order_tax_amount'=> 'numeric|min:0|lte:total_amount|nullable',
            'shipping_charge'=> 'numeric|min:0|nullable',
            'order_adjustment'=> 'numeric|lte:total_amount|nullable',
            'last_paid_amount'=> 'numeric|min:0|lte:grand_total_amount|nullable',
            'purchase_date'=> 'date|date_format:Y-m-d H:i:s,Y-m-d',
            'delivery_date'=> 'date|date_format:Y-m-d H:i:s,Y-m-d|after_or_equal:purchase_date',
            'payment_status'=> 'integer|in:0,1,2',
            'status'=> 'integer|in:0,1',
            'tax_rate'=> 'integer|min:0|nullable',
            //'line_id'=> 'required',
           'purchaseItems.*.serial_number.*'=>'string|between:3,100|nullable',
            'purchaseItems.*.product_id'=>'integer|min:0|distinct', //should check exists with product table //must not duplicate
            'purchaseItems.*.product_name'=>'string|between:3,255|nullable',
            'purchaseItems.*.product_qty'=>'required|integer|min:1',
            'purchaseItems.*.received_qty'=>'integer|min:0|lte:purchaseItems.*.product_qty|nullable',
            'purchaseItems.*.sold_qty'=>'integer|min:0|lte:purchaseItems.*.product_qty|nullable',
            // 'purchaseItems.*.unit_price'=>'required|numeric|min:0|decimal:0,4', //max:9999999.9999
            'purchaseItems.*.unit_price'=>'required|numeric|min:0',
            'purchaseItems.*.product_discount'=>'numeric|min:0|lte:purchaseItems.*.subtotal|nullable',
            'purchaseItems.*.product_tax'=>'numeric|min:0|nullable', //tax can be greater than unit price e.g car
            'purchaseItems.*.subtotal'=>'required|numeric|min:0',
            'purchaseItems.*.description'=>'string|nullable',
            'purchaseItems.*.expire_date'=>'date|date_format:Y-m-d|after_or_equal:purchaseItems.*.package_date',
            'purchaseItems.*.package_date'=>'date|date_format:Y-m-d|before_or_equal:purchaseItems.*.expire_date',
            'purchaseItems.*.is_serialized'=>'required|integer|in:0,1',
            'purchaseItems.*.is_taxable'=>'required|integer|in:0,1',
            'purchaseItems.*.status'=>'integer|in:0,1',
            
            
            
        ];

        return $rules;

    }
    public function failedValidation(Validator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
