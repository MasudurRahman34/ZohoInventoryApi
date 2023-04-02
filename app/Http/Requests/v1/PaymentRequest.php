<?php

namespace App\Http\Requests\v1;

use App\Enums\V1\PaymentMethodEnum;
use App\Enums\V1\PaymentPaidByEnum;
use App\Enums\V1\PaymentStatusEnum;
use App\Enums\V1\PaymentThankYouEnum;
use App\Enums\V1\PaymentTypeEnum;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class PaymentRequest extends FormRequest
{
    use ApiResponse;
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
            'source' => 'required|alpha|in:invoice,bill,sell',
            'payment_date' => 'date|nullable',
            "total_amount" => 'required|numeric|between:0,9999999999.9999',
            'reference' => 'string|between:3,20',

            'payment_method_number' => 'string|between:2-4',
            'paid_by' => ['required', new Enum(PaymentPaidByEnum::class)],
            'payment_method' => ['required', new Enum(PaymentMethodEnum::class)],
            'type' => ['required', new Enum(PaymentTypeEnum::class)],
            'status' => ['required', new Enum(PaymentStatusEnum::class)],
            'note' => 'nullable|string',
            'is_thankyou' => ['required', new Enum(PaymentThankYouEnum::class)],
        ];
        if ($this->request->get('source') === 'invoice') {
            $rule['paymentable_id'] = ['required', 'integer', 'exists:invoices,id'];
        } elseif ($this->request->get('source') === 'bill') {
            $rule['paymentable_id'] = ['required', 'integer', 'exists:bills,id'];
        } elseif ($this->request->get('source') === 'sell') {
            $rule['paymentable_id'] = ['required', 'integer', 'exists:sells,id'];
        }
        return $rule;
    }
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(

            $this->error($validator->errors(), 422)

        );
    }
}
