<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'paymentable_id' => $this->paymentable_id,
            'paymentable_type' => $this->paymentable_type,
            'payment_date' => $this->payment_date,
            'total_amount' => $this->total_amount,
            'reference' => $this->reference,
            'paid_by' => $this->paid_by,
            'payment_method' => $this->payment_method,
            'payment_method_number' => $this->payment_method_number,
            'status' => $this->status,
            'is_thankyou' => $this->is_thankyou,
            'note' => $this->note,
            'created_by' => $this->created_by,
            'modified_by' => $this->modified_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
