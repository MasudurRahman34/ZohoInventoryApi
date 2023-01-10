<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\Supplier;
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
        $rules=[
               
               'supplier_type' => 'required|integer|in:1,2',
            //    'supplier_number'=>'unique:portal_suppliers,supplier_number,'.$this->supplier,
               'supplier_number'=>Rule::unique('portal_suppliers')->where(fn ($query) => $query->where('account_id', Auth::user()->account_id))->ignore($this->supplier),
               'display_name' => 'required|string|between:3,100', 
               'company_name' =>'string|between:3,255|nullable',
               'website' =>'url|Max:255|nullable',
                'tax_name' =>'integer|nullable',
                'currency' =>'integer|nullable',
                'image' =>'string|max:255|nullable',
                'payment_terms' =>'integer|nullable',
                'copy_bill_address' =>'integer|in:0,1|nullable',
            ];
        if((request()->routeIs('suppliers.create')) || (request()->routeIs('suppliers.update'))){
                $rules;
        }
        else{
            $rules+=[
            //bill address
            'bill_attention'=>'string|between:3,255|nullable',
            'bill_country'=>'exists:countries,id|nullable',
            'bill_state'=>'exists:states,id|nullable',
            'bill_district'=>'exists:districts,id|nullable',
            'bill_thana'=>'exists:thanas,id|nullable',
            'bill_union'=>'exists:unions,id|nullable',
            'bill_zipcode'=>'exists:zipcodes,id|nullable',
            'bill_street_address'=>'exists:street_addresses,id|nullable',
            'bill_status'=>'integer|in:0,1|nullable', //0=invalid, 1=valid
            'bill_house'=>'string|between:5,255|nullable',
            'bill_phone' => 'numeric|size:11|nullable',
            'bill_fax' => 'string|between:5,20|nullable',
            'bill_status' => 'integer|in:0,1|nullable',
            //ship address
            'ship_attention'=>'string|between:3,255|nullable',
            'ship_country'=>'exists:countries,id|nullable',
            'ship_state'=>'exists:states,id|nullable',
            'ship_district'=>'exists:districts,id|nullable',
            'ship_thana'=>'exists:thanas,id|nullable',
            'ship_union'=>'exists:unions,id|nullable',
            'ship_zipcode'=>'exists:zipcodes,id|nullable',
            'ship_street_address'=>'exists:street_addresses,id|nullable',
            'ship_status'=>'integer|in:0,1|nullable', //0=invalid, 1=valid
            'ship_house'=>'string|between:5,255|nullable',
            'ship_phone' => 'numeric|size:11|nullable',
            'ship_fax' => 'string|between:5,20|nullable',
            'ship_status' => 'integer|in:0,1|nullable',

            //primary contact
            'primary_contact.salutation' => 'string|between:2,20|nullable',
            'primary_contact.first_name' => 'required_with:display_name|string|between:3,50|nullable',
            'primary_contact.last_name' => 'string|between:3,50|nullable',
            'primary_contact.display_name' => 'required|string|between:3,50',
            'primary_contact.company_name' => 'string|between:3,50|nullable',
            'primary_contact.phone_number_country_code' => 'string|size:3|nullable',
            'primary_contact.contact_work_phone' => 'numeric|size:11|nullable',
            'primary_contact.contact_mobile' => 'numeric|size:11|nullable',
            'primary_contact.contact_email' => ['email:rfc,filter,dns', 'max:255', 'nullable'],
            'primary_contact.facebook' => 'url|max:255|nullable',
            'primary_contact.twitter' => 'url|max:255|nullable',
            'primary_contact.skype' => 'string|max:255|nullable',
            'primary_contact.designation' => 'string|max:150|nullable',
            'primary_contact.department' => 'string|max:150|nullable',
            'primary_contact.website' => 'url|max:255|nullable',
            'primary_contact.is_primary_contact' => 'integer|in:0,1|nullable',
            'primary_contact.contact_type_id' => 'integer|min:0|nullable',

            //
            'other_contact.*.salutation' => 'string|between:2,20|nullable',
            'other_contact.*.first_name' => 'required_with:display_name|string|between:3,50|nullable',
            'other_contact.*.last_name' => 'string|between:3,50|nullable',
            'other_contact.*.display_name' => 'required|string|between:3,50',
            'other_contact.*.company_name' => 'string|between:3,50|nullable',
            'other_contact.*.contact_email' => ['email:rfc,filter,dns', 'max:255', 'nullable'],
            'other_contact.*.phone_number_country_code' => 'string|size:3|nullable',
            'other_contact.*.contact_work_phone' => 'numeric|size:11|nullable',
            'other_contact.*.contact_mobile' => 'numeric|size:11|nullable',
            'other_contact.*.facebook' => 'url|max:255|nullable',
            'other_contact.*.twitter' => 'url|max:255|nullable',
            'other_contact.*.skype' => 'string|max:255|nullable',
            'other_contact.*.designation' => 'string|max:150|nullable',
            'other_contact.*.department' => 'string|max:150|nullable',
            'other_contact.*.website' => 'url|max:255|nullable',
            'other_contact.*.is_primary_contact' => 'integer|in:0,1|nullable',
            'other_contact.*.contact_type_id' => 'integer|min:0|nullable',

            ];
        }
        return $rules;
        
    }

    public function failedValidation(contractsValidator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
