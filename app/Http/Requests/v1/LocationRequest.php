<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LocationRequest extends FormRequest
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
        // return [
        //     //
        // ];
        $rule = [
            'source' => ['required', 'string', Rule::in(['state', 'district', 'thana', 'union', 'zipcode', 'streetAddress', 'designation', 'department', 'tax', 'currency', 'companyCategory', 'company', 'model'])],
        ];
        switch ($this->request->get('source')) {
            case 'state':
                $rule['parent_id'] = ['required', 'integer', 'exists:countries,id'];
                $rule['name'] = ['required', 'regex:/^[\pL\s]+$/u', 'between:2,100'];
                break;

            case 'district':
                $rule['parent_id'] = ['required', 'integer', 'exists:states,id'];
                $rule['name'] = ['required', 'regex:/^[\pL\s]+$/u', 'between:2,150'];

                break;
            case 'thana':
                $rule['parent_id'] = ['required', 'integer', 'exists:districts,id'];
                $rule['name'] = ['required', 'regex:/^[\pL\s]+$/u', 'between:2,150'];
                break;
            case 'union':
                $rule['parent_id'] = ['required', 'integer', 'exists:thanas,id'];
                $rule['name'] = ['required', 'regex:/^[\pL\s]+$/u', 'between:2,150'];
                break;
            case 'zipcode':
                $rule['parent_id'] = ['required', 'integer', 'exists:unions,id'];
                $rule['name'] = ['required', 'integer', 'digits_between:2,10'];
                break;
            case 'streetAddress':
                $rule['parent_id'] = ['required', 'integer', 'exists:unions,id'];
                $rule['name'] = ['required', 'string', 'between:3,255'];
                break;
            case 'currency':
                $rule['name'] = ['required', 'string', 'between:2,50'];
                $rule['status'] = ['required', Rule::in(['active', 'inactive'])];
                break;

            case 'designation':
                $rule['name'] = ['required', 'string', 'between:2,50'];
                $rule['status'] = ['required', Rule::in(['active', 'inactive'])];
                break;

            case 'department':
                $rule['name'] = ['required', 'string', 'between:2,50'];
                $rule['status'] = ['required', Rule::in(['active', 'inactive'])];
                break;

            case 'tax':
                $rule['name'] = ['required', 'string', 'between:2,50'];
                $rule['rate'] = ['required', 'integer', 'min:1', 'max:100'];
                $rule['status'] = ['required', Rule::in(['active', 'inactive'])];
                break;
            case 'companyCategory':
                $rule['name'] = ['required', 'string', 'between:2,255'];
                $rule['status'] = ['required', Rule::in(['active', 'inactive'])];
                break;
            case 'company':

                $rule['name'] = ['required', 'string', 'between:2,255'];
                $rule['company_category_id'] = ['nullable', 'integer', 'exists:company_categories,id'];
                $rule['status'] = ['required', Rule::in(['active', 'inactive'])];
                break;

            case 'model':

                $rule['name'] = ['required', 'string', 'between:2,255'];
                $rule['company_id'] = ['nullable', 'integer', 'exists:companies,id'];
                $rule['status'] = ['required', Rule::in(['active', 'inactive'])];
                break;

            default:
                # code...
                break;
        }
        return $rule;
    }
}
