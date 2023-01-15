<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\Collections\PurchaseItemCollection;
use App\Models\PurchaseItem;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'supplier_id' => $this->supplier_id,
            'warehouse_id' => $this->warehouse_id,
            'invoice_no' => $this->invoice_no,
            'reference' => $this->reference,
            'total_amount' => $this->total_amount,
            'due_amount' => $this->due_amount,
            'paid_amount' => $this->paid_amount,
            'global_total_amount' => $this->global_total_amount,
            'order_discount' => $this->order_discount,
            'discount_currency' => $this->discount_currency,
            'order_tax_amount' => $this->order_tax_amount,
            'shipping_charge' => $this->shipping_charge,
            'order_adjustment' => $this->order_adjustment,
            'last_paid_amount' => $this->last_paid_amount,
            'adjustment_text' => $this->adjustment_text,
            'purchase_date' => $this->purchase_date,
            'delivery_date' => $this->delivery_date,
            'attachment_file' => $this->attachment_file,
            'image' => $this->image,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
        

            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            // 'account_id ' => $this->account_id,
            'modified_by' => $this->modified_by,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            // 'addresses' => new AddressCollection($this->whenLoaded('addresses')),
            // 'contacts' => new ContactCollection($this->whenLoaded('contacts')),
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'purchaseItems' => new PurchaseItemCollection($this->whenLoaded('purchaseItems')),

        ];
    }
}
