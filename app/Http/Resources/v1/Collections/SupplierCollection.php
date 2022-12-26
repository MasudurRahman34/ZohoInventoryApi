<?php

namespace App\Http\Resources\v1\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SupplierCollection extends ResourceCollection
{
    //public static $wrap='supplier';
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     // "message"=> "Operation Successful",
        //     // "error"=>false,
        //     // "code"=>200,
        //     'data' => $this->collection,
        // ];
    }
}
