<?php

namespace App\Http\Requests\v1;

use App\Enums\V1\WarehouseEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WarehouseRequest extends FormRequest
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
            "name" => ['required', 'between:3,255'],
            'code' => ['nullable', 'string', 'between:3,50'],
            'mobile_country_code' => ['nullable', 'required_with:mobile'],
            'mobile' => ['digits_between:7,15', 'nullable'],
            'email' => ['nullable', 'email:rfc,filter,dns', 'max:255'],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'current_balance' => ['numeric', 'nullable'],
            'default' => ['nullable', Rule::in(['true', 'false'])]
        ];
    }
}
