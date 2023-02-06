<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
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
            'first_name' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255', 'between:3,100'], //alpha space
            'last_name' => ['required', 'regex:/^[\pL\s]+$/u', 'between:3,100'], //alpha space
            'email' => ['required', 'email:rfc,filter,dns', 'max:255', 'unique:users'],
            'country' => ['required', 'integer', 'exists:countries,id'],
            'company_name' => ['regex:/^[a-zA-Z0-9@ ]+$/', 'between:3,255'],
            'password' => [
                'required', 'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'privacy_aggrement' => ['required', 'integer', 'in:1'],
            // 'g-recaptcha-response' => ['required', 'recaptcha'],
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(

            $this->error($validator->errors(), 422)

        );
    }
    public function messages()
    {
        return [
            'g-recaptcha-response' => 'invalid recaptcha'
        ];
    }
}
