<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
        return[
            "id"=> $this->id,
            "ref_object_key"=> $this->ref_object_key,
            "ref_id"=>  $this->ref_id,
            "salutation"=>$this->salutation,
            "first_name"=> $this->first_name,
            "last_name"=> $this->last_name,
            "display_name"=> $this->display_name,
            "company_name"=>$this->company_name,
            "contact_email"=> $this->contact_email,
            "phone_number_country_code"=> $this->phone_number_country_code,
            "contact_work_phone"=> $this->contact_work_phone,
            "contact_mobile"=> $this->contact_mobile,
            "skype"=> $this->skype,
            "facebook"=> $this->facebook,
            "twitter"=> $this->twitter,
            "designation"=>$this->designation,
            "department"=> $this->department,
            "website"=> $this->website,
            "is_primary_contact"=> $this->is_primary_contact,
            "contact_type_id"=> $this->contact_type_id,
            "created_by"=> $this->created_by,
            "modified_by"=> $this->modified_by,
            //"account_id"=> $this->account_id,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
            "deleted_at"=> $this->deleted_at
        ];
    }
}
