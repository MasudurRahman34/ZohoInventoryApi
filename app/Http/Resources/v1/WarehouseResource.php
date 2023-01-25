<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'phone_country_code' => $this->phone_country_code,
            'mobile_country_code' => $this->mobile_country_code,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'address' => $this->address,
            'description' => $this->description,
            'current_balance' => $this->current_balance,
            'created_by' => $this->created_by,
            'modified_by' => $this->modified_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        
        ];
    }
}
