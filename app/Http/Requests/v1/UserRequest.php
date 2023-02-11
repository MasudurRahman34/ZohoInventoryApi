<?php

namespace App\Http\Requests\v1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        // /^[+-]?\d+$/
        return [
            'first_name' => ['filled', 'regex:/^[\pL\s]+$/u', 'between:3,100'], //alpha space
            'last_name' => ['filled', 'required_with:first_name', 'regex:/^[\pL\s]+$/u', 'between:3,100'], //alpha space
            // 'company_name' => ['required', 'alpha', 'regex:/^[a-zA-Z0-9@ ]+$/', 'between:3,255'], //alpha space or alpha numeric, alpha @,
            'mobile' => ['filled', 'required_with:mobile_country_code', 'digits_between:7,15', Rule::unique('users', 'mobile')->ignore($this->uuid, 'uuid')],
            'country' => ['filled', 'string', 'exists:countries,id'],
            'mobile_country_code' => ['filled', 'required_with:mobile', 'regex:/^\+\d{1,3}$/', 'between:2,6'],
            'notify_new_user' => ['filled', 'in:0,1'],
            'country_code' => ['filled', 'required_with:country', 'alpha', 'exists:countries,iso2'],
            'status' => ['filled', 'in:0,1,2,3'],
            'date_of_birth' => ['filled', 'date', 'date_format:Y-m-d', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'gender' => ['filled', 'in:male, female, other'],
            'language' => ['filled', 'alpha', 'between:3,100'],
            'about' => ['filled', 'string'],
            'occupation' => ['filled', 'regex:/^[\pL\s]+$/u'],
            'signup_business_step' => ['filled', 'in:1'],
        ];
    }
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(

            $this->error($validator->errors(), 422)

        );
    }
    public function message(): array
    {
        return [
            'company_name.alpha' => 'compnay Name Must Contain Alpha',
        ];
    }
}
