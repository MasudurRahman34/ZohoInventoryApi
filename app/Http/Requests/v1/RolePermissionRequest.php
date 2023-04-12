<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RolePermissionRequest extends FormRequest
{
    use ApiResponse;
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

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(

               $this->error($validator->errors(),422)

        );
    }


}
