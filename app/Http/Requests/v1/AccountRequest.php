<?php

namespace App\Http\Requests\v1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class AccountRequest extends FormRequest
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
            'first_name' => 'required|string|between:3,100',
            'last_name' => 'required|string|between:3,100',
            'company_name' => 'string|max:255',
            'module_name' => 'array|nullable',
            'compnay_logo' => 'string|nullable',
            'dashboard_blocks' => 'string|nullable',
            'ip_address_access' => 'string|nullable',
            'language' => 'string|between:3,25|nullable',
            'domain' => 'string|nullable',
            'host' => 'url|nullable',
            'database_name' => 'string|nullable',
            'database_user' => 'string|nullable',
            'database_password' => 'string|nullable',
            'business_type_id' => 'integer|exists:business_types,id',
            'user_id' => 'integer|exists:users,id',
        ];
    }
    // public function failedValidation(Validator $validator)
    // {

    //     throw new HttpResponseException(

    //         $this->error($validator->errors(), 422)

    //     );
    // }
}
