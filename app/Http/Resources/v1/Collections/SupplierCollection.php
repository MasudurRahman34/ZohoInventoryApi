<?php

namespace App\Http\Resources\v1\Collections;

use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\ContactResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SupplierCollection extends ResourceCollection
{
    //public static $wrap='supplier';
    public function toArray($request)
    {
        return parent::toArray($request);
        //    return[
        //     'id' => $this->id,
        //     'supplier_number' => $this->supplier_number,
        //     'supplier_type' => $this->supplier_type,
        //     'display_name' => $this->display_name,
        //     'company_name' => $this->company_name,
        //     'website' => $this->website,
        //     'tax_name' => $this->tax_name,
        //     'tax_rate' => $this->tax_rate,
        //     'currency' => $this->currency,
        //     'image' => $this->image,
        //     'payment_terms' => $this->payment_terms,
        //     'copy_bill_address' => $this->copy_bill_address,

        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //     'created_by' => $this->created_by,
        //     //'account_id ' => $this->account_id,
        //     'modified_by' => $this->modified_by,
        //     'updated_at' => $this->updated_at,
        //     'deleted_at' => $this->deleted_at,

        //     // 'addresses' => new AddressCollection($this->whenLoaded('addresses')),
        //     // 'contacts' => new ContactCollection($this->whenLoaded('contacts')),
        //     'primary_contact' => new ContactResource($this->whenLoaded('PrimaryContact')),
        //     'other_contacts' => new ContactCollection($this->whenLoaded('otherContacts')),
        //     'ship_address' => new AddressResource($this->whenLoaded('shipAddress')),
        //     'bill_address' => new AddressResource($this->whenLoaded('billAddress')),
        //     'other_addresses' => new AddressCollection($this->whenLoaded('otherAddresses')),


        //     ];
    }
}
