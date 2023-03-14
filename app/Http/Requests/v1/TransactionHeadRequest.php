<?php

namespace App\Http\Requests\v1;

use App\Enums\V1\TransactionHeadEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class TransactionHeadRequest extends FormRequest
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
            'head_name' => ['required', 'regex:/^[\pL\s]+$/u', 'between:3,200'], //alpha space
            'type' => ['required', new Enum(TransactionHeadEnum::class)],
            'sort' => ['integer', 'nullable'],
            'description' => ['string', 'nullable']
        ];
    }
}
