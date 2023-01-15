<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\Collections\PurchaseItemCollection;
use App\Models\SaleItem;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'customer_id' => $this->customer_id,
            'warehouse_id' => $this->warehouse_id,
            'order_number' => $this->order_number,
            'sales_order_date' => $this->sales_order_date,
            'expected_shipment_date' => $this->expected_shipment_date,
            'billing_address' => $this->billing_address,
            'shipping_address' => $this->shipping_address,
            'delivery_method' => $this->delivery_method,
            'reference' => $this->reference,
            'order_discount' => $this->order_discount,
            'discount_currency' => $this->discount_currency,
            'order_discount_amount' => $this->order_discount_amount,
            'order_tax' => $this->order_tax,
            'order_tax_amount' => $this->order_tax_amount,
            'shipping_charge' => $this->shipping_charge,
            'order_adjustment' => $this->order_adjustment,
            'adjustment_text' => $this->adjustment_text,
            'customer_note' => $this->customer_note,
            'total_amount' => $this->total_amount,
            'terms_condition' => $this->terms_condition,
            'paid_amount' => $this->paid_amount,
            'recieved_amount' => $this->recieved_amount,
            'changed_amount' => $this->changed_amount,
            'last_paid_amount' => $this->last_paid_amount,
            'attachment_file' => $this->attachment_file,
            'image' => $this->image,
            'offer_to' => $this->offer_to,
            'offer_subject' => $this->offer_subject,
            'offer_greetings' => $this->offer_greetings,
            'offer_terms_condition' => $this->offer_terms_condition,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'sales_type' => $this->sales_type,
            'salesperson' => $this->salesperson,

            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
           // 'account_id ' => $this->account_id,
            'modified_by' => $this->modified_by,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            // 'addresses' => new AddressCollection($this->whenLoaded('addresses')),
            // 'contacts' => new ContactCollection($this->whenLoaded('contacts')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'saleItems' => new PurchaseItemCollection($this->whenLoaded('saleItems')),

        ];
    }
}
