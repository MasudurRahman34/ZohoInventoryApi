<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
            'id'=>$this->id,
            'product_id'=>$this->product_id,
            'warehouse_id'=>$this->warehouse_id,
            'date'=>$this->date,
            'quantity'=>$this->quantity,
            'purchase_quantity'=>$this->purchase_quantity,
            'sale_quantity'=>$this->sale_quantity,
            'quantity_on_hand'=>$this->quantity_on_hand,
            'opening_stock_value'=>$this->opening_stock_value,
           
            'created_by' => $this->created_by,
            'modified_by' => $this->modified_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
