<?php

namespace App\Http\Resources\v1\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SupplierCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            // "message"=> "Operation Successful",
            // "error"=>false,
            'data' => $this->collection,
            // 'links' => [
            //     'self' => 'link-value',
            // ],
        ];
    }
}
