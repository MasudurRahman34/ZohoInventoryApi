<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InventoryAdjustmentRequest extends FormRequest
{
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

            'source' => 'required|string|in:sale,purchase,inventory_adjustment',
            'mode_of_adjustment' => 'required|integer|in:1,2', //customer, supplier, user
            'reference_number' => 'required|string|between:3,20',
            'adjustment_date' => 'required|date|date_format:Y-m-d H:i:s,Y-m-d|after_or_equal:today',
            // 'account'=>'required|integer|exists:transaction_heads,id',
            'account' => 'required|integer|min:0',
            'reason_id' => 'required|integer|exists:item_adjustment_reasons,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'description' => 'string|nullable',
        ];
    }
}
