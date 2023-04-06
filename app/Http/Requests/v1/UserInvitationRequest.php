<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'regex:/^[\pL\s]+$/u', 'between:3,100'], //alpha space
            // 'last_name' => ['required', 'required_with:first_name', 'regex:/^[\pL\s]+$/u', 'between:3,100'],
            'email' => ['required', 'email:rfc,filter,dns', 'max:255', 'unique:users'],
            'role' => ['string', 'required'],
        ];
    }
}
