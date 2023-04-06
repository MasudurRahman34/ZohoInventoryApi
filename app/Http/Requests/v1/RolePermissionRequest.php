<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RolePermissionRequest extends FormRequest
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
            "name" => ['string', "regex:/^[\p{L} ,.'-_]+$/u", 'between:2,50', 'required'],
            'permissions' => ['array', 'required'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
            'status' => [Rule::in(['active', 'inative'])],
            'default' => ['nullable', Rule::in(['no'])],
            'description' => ['string', 'nullable'],
        ];
    }
}
