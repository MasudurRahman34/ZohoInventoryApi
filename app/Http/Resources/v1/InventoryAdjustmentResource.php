<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\Collections\AdjustmentItemCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryAdjustmentResource extends JsonResource
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
            'mode_of_adjustment' => $this->mode_of_adjustment,
            'inventory_adjustmentable_id' => $this->inventory_adjustmentable_id,
            'inventory_adjustmentable_type' => $this->inventory_adjustmentable_type,
            'reference_number' => $this->reference_number,
            'adjustment_date' => $this->adjustment_date,
            'account' => $this->account,
            'reason_id' => $this->reason_id,
            'warehouse_id' => $this->warehouse_id,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            // 'account_id ' => $this->account_id,
            'modified_by' => $this->modified_by,
            'itemAdjustmentReason' => $this->whenLoaded('itemAdjustmentReason'),

            // 'adjustmentItems' => new SupplierResource($this->whenLoaded('supplier')),
            'adjustmentItems' => new AdjustmentItemCollection($this->whenLoaded('adjustmentItems')),



        ];
    }
}
