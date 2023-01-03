<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator as contractsValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Support\Facades\Validator;


class SupplierRequest extends FormRequest
{ use ApiResponse;
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
           
                'display_name' => 'required|string|max:100',
                'company_name' => 'string',
               'supplier_type' => 'required|integer|in:1,2',
               'copy_bill_address' => 'integer|in:0,1',
               'supplier_number'=>'unique:portal_suppliers,supplier_number,'.$this->supplier,
            // 'supplier_number'=>Rule::unique('portal_suppliers','supplier_number')->where(function ($query) {
            //     return $query->where('portal_suppliers.account_id', Auth::user()->account_id)->where('portal_suppliers.id',$this->id);
            // })
        ];
    }

    public function failedValidation(contractsValidator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
