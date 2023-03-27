<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductVarientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rule = [
            "source" => ['required', Rule::in(['attribute', 'attributeValue', 'itemCategory'])],
        ];
        if (request()->routeIs('product-variant.index')) {
            return $rule;
        } else {
            switch ($this->request->get('source')) {
                case 'itemCategory':
                    $rule['name'] = ['required', 'string'];
                    $rule['parent_id'] = ['nullable', 'integer', 'exists:item_categories,id'];
            }

            return $rule;
        }
    }
}
