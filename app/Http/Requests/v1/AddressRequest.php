<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

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
       return Auth::check();
        //return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rule= [
            //'attention'=>'required|string',
            'ref_id' => ['required','integer'],
            'source' => 'required|string|in:customer,supplier,user', //customer, supplier, user
            'country_id'=>'exists:countries,id|nullable',
            'state_id'=>'exists:states,id|nullable',
            'district_id'=>'exists:districts,id|nullable',
            'thana_id'=>'exists:thanas,id|nullable',
            'union_id'=>'exists:unions,id|nullable',
            'zipcode'=>'exists:zipcodes,id|nullable',
            'street_address_id'=>'exists:street_addresses,id|nullable',
            'is_bill_address'=>'integer|in:0,1|nullable', //1=yes, 0=no
            'is_ship_address'=>'integer|in:0|nullable', //1=yes, 0=no
            'status'=>'integer|in:0,1|nullable', //0=invalid, 1=valid
            'house'=>'string|between:5,255|nullable',
            'phone' => 'numeric|size:11|nullable',
            'fax' => 'string|between:5,20|nullable',
            'status' => 'integer|in:0,1|nullable',
        ];
        if ($this->request->get('source') === 'supplier') {
            $rule['ref_id'] = ['required','integer','exists:portal_suppliers,id'];
        } elseif ($this->request->get('source') === 'customer') {
            $rule['ref_id'] = ['required','integer','exists:portal_customers,id'];
        } elseif ($this->request->get('source') === 'user') {
            $rule['ref_id'] = ['required','integer','exists:users,id'];
        }
        return $rule;
    }
    public function failedValidation(Validator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
