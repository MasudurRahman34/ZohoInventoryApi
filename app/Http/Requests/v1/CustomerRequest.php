<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator as contractsValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;

class CustomerRequest extends FormRequest
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
        $rules=[
               
            'customer_type' => 'required|integer|in:1,2',
            'customer_number'=>Rule::unique('portal_customers')->where(fn ($query) => $query->where('account_id', Auth::user()->account_id))->ignore($this->customer),
            'display_name' => 'required|string|between:3,100', 
            'company_name' =>'string|between:3,255|nullable',
            'website' =>'url|Max:255|nullable',
             'tax_name' =>'integer|nullable',
             'currency' =>'integer|nullable',
             'image' =>'string|max:255|nullable',
             'payment_terms' =>'integer|nullable',
             'copy_bill_address' =>'integer|in:0,1|nullable',
         ];
     if((request()->routeIs('customers.create')) || (request()->routeIs('customers.update'))){
             $rules;
     }
     else{
         $rules+=[
         //bill address
         'bill_attention'=>'string|between:3,255|nullable',
         'bill_country'=>'integer|exists:countries,id|nullable',
         'bill_state'=>'integer|exists:states,id|nullable',
         'bill_district'=>'integer|exists:districts,id|nullable',
         'bill_thana'=>'integer|exists:thanas,id|nullable',
         'bill_union'=>'integer|exists:unions,id|nullable',
         'bill_zipcode'=>'integer|exists:zipcodes,id|nullable',
         'bill_street_address'=>'integer|exists:street_addresses,id|nullable',
         'bill_status'=>'integer|in:0,1|nullable', //0=invalid, 1=valid
         'bill_house'=>'string|between:3,255|nullable',
         'bill_phone' => 'digits_between:7,15|nullable',
         'bill_fax' => 'string|between:5,20|nullable',
         'bill_status' => 'integer|in:0,1|nullable',
         //ship address
         'ship_attention'=>'string|between:3,255|nullable',
         'ship_country'=>'integer|exists:countries,id|nullable',
         'ship_state'=>'integer|exists:states,id|nullable',
         'ship_district'=>'integer|exists:districts,id|nullable',
         'ship_thana'=>'integer|exists:thanas,id|nullable',
         'ship_union'=>'integer|exists:unions,id|nullable',
         'ship_zipcode'=>'integer|exists:zipcodes,id|nullable',
         'ship_street_address'=>'integer|exists:street_addresses,id|nullable',
         'ship_status'=>'integer|in:0,1|nullable', //0=invalid, 1=valid
         'ship_house'=>'string|between:3,255|nullable',
         'ship_phone' => 'digits_between:7,15|nullable',
         'ship_fax' => 'string|between:5,20|nullable',
         'ship_status' => 'integer|in:0,1|nullable',

         //primary contact
         'primary_contact.salutation' => 'alpha|between:2,20|nullable',
         'primary_contact.first_name' => 'alpha|between:3,50|nullable',
         'primary_contact.last_name' => 'alpha|between:3,50|nullable',
         'primary_contact.display_name' => 'string|between:3,50|nullable',
         'primary_contact.company_name' => 'string|between:3,255|nullable',
         'primary_contact.phone_number_country_code' => 'string|between:1,3|nullable',
         'primary_contact.contact_work_phone' => 'digits_between:7,15|nullable',
         'primary_contact.contact_mobile' => 'digits_between:7,15|nullable',
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
         'other_contact.*.salutation' => 'alpha|between:2,20|nullable',
         'other_contact.*.first_name' => 'alpha|between:3,50|nullable',
         'other_contact.*.last_name' => 'alpha|between:3,50|nullable',
         'other_contact.*.display_name' => 'string|between:3,50|nullable',
         'other_contact.*.company_name' => 'string|between:3,255|nullable',
         'other_contact.*.contact_email' => ['email:rfc,filter,dns','max:255','nullable'],
         'other_contact.*.phone_number_country_code' => 'string|between:1,3|nullable',
         'other_contact.*.contact_work_phone' => 'digits_between:7,15|nullable',
         'other_contact.*.contact_mobile' => 'digits_between:7,15|nullable',
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
