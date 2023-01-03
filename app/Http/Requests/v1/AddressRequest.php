<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressRequest extends FormRequest
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
            //'attention'=>'required|string',
            'ref_id' => 'required|integer',
            'source' => 'required|string|in:customer,supplier,user', //customer, supplier, user
            'country_id'=>'integer|min:0|nullable',
            'state_id'=>'integer|min:0|nullable',
            'district_id'=>'integer|min:0|nullable',
            'thana_id'=>'integer|min:0|nullable',
            'union_id'=>'integer|min:0|nullable',
            'street_address_id'=>'integer|min:0|nullable',
            'is_bill_address'=>'integer|in:0,1|nullable', //1=yes, 0=no
            'is_ship_address'=>'integer|in:0|nullable', //1=yes, 0=no
            'status'=>'integer|in:0,1'|'nullable', //0=invalid, 1=valid
        ];
    }
    public function failedValidation(Validator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
