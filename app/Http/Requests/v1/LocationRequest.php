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
//       $this->merge(['source' => $this->route('source')]);
        $rule = [
            'source' => ['required', 'string', Rule::in(['state', 'district', 'thana', 'union', 'zipcode', 'street-address', 'designation', 'department', 'tax', 'currency', 'companyCategory', 'company', 'model'])],
        ];
        $source = $this->request->get('source');
        $parent_id = $this->request->get('parent_id');
        $user = Auth::guard('api')->user();
//        dd($user->account_id);
        switch ($source) {
            case 'state':
                $rule['parent_id'] = ['required', 'string', 'exists:countries,iso2'];
                $rule['value'] = ['required', Rule::unique('states', 'state_name')->where(function($query) use ($parent_id){
                    return $query->where('country_iso2', $parent_id);
            }), 'regex:/^[\pL\s]+$/u', 'between:2,100'];
                break;

            case 'district':
                $rule['parent_id'] = ['required', 'integer', 'exists:states,id'];
                $rule['value'] = ['required', Rule::unique('districts', 'district_name')->where(function($query) use ($parent_id){
                    return $query->where('state_id', $parent_id);
                }),'regex:/^[\pL\s]+$/u', 'between:2,150'];

                break;
            case 'thana':
                $rule['parent_id'] = ['required', 'integer', 'exists:districts,id'];
                $rule['value'] = ['required', Rule::unique('thanas', 'thana_name')->where(function ($query) use ($parent_id){
                    return $query->where('district_id', $parent_id);
                }), 'regex:/^[\pL\s]+$/u', 'between:2,150'];
                break;
            case 'union':
                $rule['parent_id'] = ['required', 'integer', 'exists:thanas,id'];
                $rule['value'] = ['required', Rule::unique('unions', 'union_name')->where(function($query) use ($parent_id){
                    return $query->where('thana_id', $parent_id);
                }), 'regex:/^[\pL\s]+$/u', 'between:2,150'];
                break;
            case 'zipcode':
                $rule['parent_id'] = ['required', 'integer', 'exists:thanas,id'];
                $rule['value'] = ['required', Rule::unique('zipcodes', 'zip_code')->where(function($query) use ($parent_id){
                    return $query->where('thana_id', $parent_id);
                }), 'string', 'digits_between:2,10'];
                break;
            case 'street-address':
                $rule['parent_id'] = ['required', 'integer', 'exists:unions,id'];
                $rule['value'] = ['required', 'string', Rule::unique('street_addresses', 'street_address_value')->where(function($query) use ($parent_id){
                    return $query->where('union_id', $parent_id);
                }), 'between:3,255'];
                break;
            case 'designation':
                $rule['value'] = ['required', Rule::unique('designations', 'name')->where(function($query) use ($user){
                    return $query->where('account_id', $user->account_id);
                }), 'string', 'between:2,50'];
                break;
            case 'currency':
                $rule['value'] = ['required', Rule::unique('designations', 'name')->where(function($query) use ($user){
                    return $query->where('account_id', $user->account_id);
                }), 'string', 'between:2,50'];
                break;
            case 'department':
                $rule['value'] = ['required', Rule::unique('departments', 'name')->where(function($query) use ($user){
                    return $query->where('account_id', $user->account_id);
                }), 'string', 'between:2,50'];
                break;

            case 'tax':
                $rule['value'] = ['required', Rule::unique('taxes', 'name')->where(function($query) use ($user){
                    return $query->where('account_id', $user->account_id);
                }), 'string', 'between:2,50'];
                $rule['rate'] = ['required', 'numeric', 'between:0,99.99'];
                break;
            case 'companyCategory':
                $rule['value'] = ['required', 'string', 'between:2,255'];
                break;
            case 'company':
                $rule['value'] = ['required', 'string', 'between:2,255'];
                $rule['company_category_id'] = ['nullable', 'integer', 'exists:company_categories,id'];
                break;
            case 'model':
                $rule['value'] = ['required', 'string', 'between:2,255'];
                $rule['company_id'] = ['nullable', 'integer', 'exists:companies,id'];
                break;

            default:
                # code...
                break;
        }
        return $rule;
    }
}
