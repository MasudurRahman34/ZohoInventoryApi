<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'supplier_id' => 'required|integer|min:0',
            'warehouse_id' => 'required|integer|min:0',
            'line_id'=> 'required',
            'total_amount'=> 'numeric',
            'due_amount'=> 'numeric',
            'grand_total_amount'=> 'numeric',
            'order_discount'=> 'numeric',
            'discount_currency'=> 'numeric',
            'order_tax'=> 'numeric',
            'order_tax_amount'=> 'numeric',
            'shipping_charge'=> 'numeric',
            'order_adjustment'=> 'numeric',
            'last_paid_amount'=> 'numeric',
            'purchase_date'=> 'date|date_format:Y-m-d H:i:s',
            'delivery_date'=> 'date|date_format:Y-m-d H:i:s|',
            'payment_status'=> 'integer|in:0,1,2',
            'status'=> 'integer|in:0,1',
            //'line_id'=> 'required',
        ];
    }
    public function failedValidation(Validator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
