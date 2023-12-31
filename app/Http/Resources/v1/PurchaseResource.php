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
            'supplier_name' => $this->supplier_name,
            'warehouse_id' => $this->warehouse_id,
            'purchase_number' => $this->purchase_number,
            'reference' => $this->reference,
            'total_amount' => $this->total_amount,
            'total_whole_amount' => $this->total_whole_amount,
            'total_tax' => $this->total_tax,
            'total_product_discount' => $this->total_product_discount,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'due_amount' => $this->due_amount,
            'paid_amount' => $this->paid_amount,
            'grand_total_amount' => $this->grand_total_amount,
            'balance' => $this->balance,
            'order_tax_amount' => $this->order_tax_amount,
            'shipping_charge' => $this->shipping_charge,
            'order_adjustment' => $this->order_adjustment,
            'last_paid_amount' => $this->last_paid_amount,
            'adjustment_text' => $this->adjustment_text,
            'purchase_date' => $this->purchase_date,
            'delivery_date' => $this->delivery_date,
            'purchase_terms' => $this->purchase_terms,
            'purchase_description' => $this->purchase_description,
            'purchase_type' => $this->purchase_type,
            'payment_term' => $this->payment_term,
            'purchase_currency' => $this->purchase_currency,
            // 'attachment_file' => $this->attachment_file,
            // 'image' => $this->image,
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
            'inventoryAdjustment' => new InventoryAdjustmentResource($this->whenLoaded('inventoryAdjustment')),

        ];
    }
}
