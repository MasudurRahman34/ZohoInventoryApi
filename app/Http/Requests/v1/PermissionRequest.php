<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
            'name' => ['string', "regex:/^[\p{L} ,.'-_]+$/u", 'between:2,50', 'required'],
            'title'=>['string', "regex:/^[\p{L} ,.'-_]+$/u", 'between:2,255', 'required'],
            'permission_groups_id' => ['integer', 'required', 'exists:permission_groups,id'],
            'is_global' => [Rule::in(['default']), 'nullable'],
            'status' => [Rule::in(['active', 'inactive']), 'nullable'],
            'description' => ['string', 'nullable'],
            'sort' => ['integer', 'nullable', 'min:0', 'max:10'],


        ];
    }
}