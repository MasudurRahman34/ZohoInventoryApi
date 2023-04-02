<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\Collections\AddressCollection;
use App\Http\Resources\v1\Collections\ContactCollection;
use App\Http\Resources\v1\Collections\PurchaseCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{

    // public $preserveKeys = true;
    public static $wrap = 'supplier';
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'supplier_number' => $this->supplier_number,
            'supplier_type' => $this->supplier_type,
            'display_name' => $this->display_name,
            'company_name' => $this->company_name,
            'website' => $this->website,
            'tax_name' => $this->tax_name,
            'tax_rate' => $this->tax_rate,
            'currency' => $this->currency,
            'image' => $this->image,
            'payment_terms' => $this->payment_terms,
            'copy_bill_address' => $this->copy_bill_address,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'account_id ' => $this->account_id,
            'modified_by' => $this->modified_by,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'allAddresses' => $this->all_addresses,
            // 'contacts' => new ContactCollection($this->whenLoaded('contacts')),
            'primaryContact' => new ContactResource($this->whenLoaded('PrimaryContact')),
            'otherContacts' => new ContactCollection($this->whenLoaded('otherContacts')),
            'shipAddress' => new AddressResource($this->whenLoaded('shipAddress')),
            'billAddress' => new AddressResource($this->whenLoaded('billAddress')),
            'otherAddresses' => new AddressCollection($this->whenLoaded('otherAddresses')),
            'purchases' => new PurchaseCollection($this->whenLoaded('purchases')),


        ];
    }
    // public function with($request)
    // {
    //     return [
    //         'meta' => [
    //             'key' => 'value',
    //         ],
    //     ];
    // }
}
