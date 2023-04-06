<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email:rfc,filter,dns', 'max:255', 'unique:users'],
            // 'first_name' => ['filled', 'regex:/^[\pL\s]+$/u', 'max:255', 'between:3,100'],
            'role' => ['required', 'exists:roles, name'],
        ];
    }
}
