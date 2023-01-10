<?php

namespace App\Http\Requests\v1;

use Illuminate\Contracts\Validation\Validator as contractsValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
        $rule= [
            'source' => 'required|string|in:customer,supplier,user', //customer, supplier, user
            'salutation' => 'string|between:2,20|nullable',
            'first_name' => 'required_with:display_name|string|between:3,50|nullable',
            'last_name' => 'string|between:3,50|nullable',
            'display_name' => 'required|string|between:3,50',
            'company_name' => 'string|between:3,50|nullable',
            'phone_number_country_code' => 'string|size:3|nullable',
            'contact_email' => ['email:rfc,filter,dns', 'max:255', 'nullable'],
            'contact_work_phone' => 'numeric|size:11|nullable',
            'contact_mobile' => 'numeric|size:11|nullable',
            'facebook' => 'url|max:255|nullable',
            'twitter' => 'url|max:255|nullable',
            'skype' => 'string|max:255|nullable',
            'designation' => 'string|max:150|nullable',
            'department' => 'string|max:150|nullable',
            'website' => 'url|max:255|nullable',
            'is_primary_contact' => 'integer|in:0,1|nullable',
            'contact_type_id' => 'integer|min:0|nullable', //contact_type table not present that's why not check with table
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
    public function failedValidation(contractsValidator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }

}
