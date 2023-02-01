<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewPasswordResetRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'token' => 'required', 'exists:password_resets,token',
            'email' => ['required', 'email:rfc,filter,dns', 'max:255', 'exists:users,email'],
            'password' => [
                'required', 'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
    }
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(

            $this->error($validator->errors(), 422)

        );
    }
}
