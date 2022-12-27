<?php

namespace App\Http\Requests\v1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;

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
        return [
            'source' => 'required|string',
            'ref_id' => 'required|integer', //customer, supplier, user
        ];
    }
    public function failedValidation(Validator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }

}
