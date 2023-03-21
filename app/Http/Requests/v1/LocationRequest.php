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
            'source' => ['required', 'string', Rule::in(['state', 'district', 'thana', 'union', 'zipcode', 'streetAddress'])],
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

            default:
                # code...
                break;
        }
        return $rule;
    }
}
