<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Rules\V1\MatchOldPassword;
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
            'token' => ['required'],
            'email' => ['required', 'email:rfc,filter,dns', 'max:255', 'exists:users,email'],
            'old_password_token' => 'present',
            'password' => [
                'required', 'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), new MatchOldPassword(),
            ],

        ];
    }
    public function failedValidation(Validator $validator)
    {
        $old_password_token['old_password_token'] = session()->has('old_password_token') ? session('old_password_token') : null;

        throw new HttpResponseException(

            $this->error($validator->errors(), 422, $old_password_token)

        );
    }
}
