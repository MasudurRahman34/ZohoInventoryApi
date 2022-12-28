<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

        return [
            "id"=> $this->id,
            "ref_object_key"=> $this->ref_object_key,
            "ref_id"=> $this->ref_id,
            "attention"=> $this->attention,
            "country_id"=> $this->country_id,
            "state_id"=> $this->state_id,
            "district_id"=> $this->district_id,
            "thana_id"=> $this->thana_id,
            "union_id"=> $this->union_id,
            "zipcode_id"=> $this->zipcode_id,
            "street_address_id"=> $this->street_address_id,
            "house"=> $this->house,
            "phone"=>$this->phone,
            "fax"=>$this->fax,
            "is_bill_address"=>$this->is_bill_address,
            "is_ship_address"=> $this->is_ship_address,
            "status"=> $this->status,
            "full_address"=>$this->full_address,
           // "account_id"=> $this->account_id,
            "created_by"=>$this->created_by,
            "modified_by"=> $this->modified_by,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
            "deleted_at"=> $this->deleted_at
        ];
        }
}
