<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\Collections\BillItemCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BillResource extends JsonResource
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
            'uuid' => $this->uuid,
            'supplier_id' => $this->supplier_id,
            'supplier_name' => $this->supplier_name,
            'user_ip' => $this->user_ip,
            'billing_person' => $this->billing_person,
            'bill_number' => $this->bill_number,
            'short_code ' => $this->short_code,
            'reference' => $this->reference,
            'order_id' => $this->order_id,
            'order_number' => $this->order_number,
            'total_amount' => $this->total_amount,
            'bill_date' => $this->bill_date,
            'due_date' => $this->due_date,
            'order_tax' => $this->order_tax,
            'order_tax_amount' => $this->order_tax_amount,
            'order_discount' => $this->order_discount,
            'discount_amount' => $this->discount_amount,
            'shipping_charge' => $this->shipping_charge,
            'order_adjustment' => $this->order_adjustment,
            'total_amount' => $this->total_amount,
            'total_whole_amount' => $this->total_whole_amount,
            'total_tax' => $this->total_tax,
            'total_product_discount' => $this->total_product_discount,
            'grand_total_amount' => $this->grand_total_amount,

            'balance' => $this->balance,
            'due_amount' => $this->due_amount,
            'paid_amount' => $this->paid_amount,


            'last_paid' => $this->last_paid,
            'adjustment_text' => $this->adjustment_text,
            'bill_terms' => $this->bill_terms,
            'bill_description' => $this->bill_description,
            'bill_type' => $this->bill_type,
            'bill_currency' => $this->bill_currency,
            'payment_term' => $this->payment_term,
            'status' => $this->status,
            'download' => $this->download,
            'pdf_link' => $this->pdf_link,

            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            // 'account_id ' => $this->account_id,
            'modified_by' => $this->modified_by,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            // 'addresses' => new AddressCollection($this->whenLoaded('addresses')),
            // 'contacts' => new ContactCollection($this->whenLoaded('contacts')),
            'billItems' => new BillItemCollection($this->whenLoaded('billItems')),
            'senderAddress' => new SendeAddressResource($this->whenLoaded('senderAddress')),
            'receiverAddress' => new ReceiverAddressResource($this->whenLoaded('receiverAddress')),

        ];
    }
}
