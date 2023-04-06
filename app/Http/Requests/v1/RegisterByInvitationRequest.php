<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterByInvitationRequest extends FormRequest
{
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
            // 'first_name' => ['required', 'regex:/^[\pL\s]+$/u', 'between:3,100'], //alpha space
            // 'last_name' => ['required', 'regex:/^[\pL\s]+$/u', 'between:3,100'], //alpha space
            'email' => ['required', 'email:rfc,filter,dns', 'max:255', 'unique:users'],
            'token' => ['required', 'exists:user_invites,token'],
            'password' => [
                'required', 'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'privacy_aggrement' => ['required', 'integer', 'in:1'],
        ];
    }
    public function failedValidatio(Validator $validator)
    {

        throw new HttpResponseException(

            $this->error($validator->errors(), 422)

        );
    }
}
