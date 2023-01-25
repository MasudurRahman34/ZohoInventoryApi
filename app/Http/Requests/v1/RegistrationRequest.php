<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
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
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'mobile' => ['required','unique:users','digits_between:7,15'],
            'country' => ['required','string','exists:countries,id'],
            'mobile_country_code' => ['required','between:1,3'],
            'notify_new_user'=>['in:0,1'],
            'status'=>['in:0,1,2,3'],
            'password' => ['required','confirmed', Password::min(8)
                            ->letters()
                            ->mixedCase()
                            ->numbers()
                            ->symbols()
                            ->uncompromised()                          
                            ]
            ];
    }

    public function failedValidation(Validator $validator){
       
        throw new HttpResponseException(
           
               $this->error($validator->errors(),422)
            
        );
    }
}
