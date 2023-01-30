<?php

namespace App\Http\Services\V1;


use App\Models\BusinessType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BusinessTypeService
{


    public function store($request)
    {


        $busnessTypeData =
            [

                'type_name' => isset($request['type_name']) ? $request['type_name'] : NULL,
                'category_type' => isset($request['category_type']) ? $request['category_type'] : NULL,
                'parent_id' => isset($request['parent_id']) ? $request['parent_id'] : 0,
                'status' => isset($request['status']) ? $request['status'] : NULL,

            ];

        $newBusinessType = BusinessType::create($busnessTypeData);
        return $newBusinessType;
    }

    public function update($request, $busnessType)
    {

        $busnessTypeData =
            [

                'type_name' => isset($request['type_name']) ? $request['type_name'] : $busnessType->type_name,
                'category_type' => isset($request['category_type']) ? $request['category_type'] : $busnessType->category_type,
                'parent_id' => isset($request['parent_id']) ? $request['parent_id'] : $busnessType->parent_id,
                'status' => isset($request['status']) ? $request['status'] : $busnessType->status,

            ];

        // return $busnessTypeData;
        $updatedBusinessType =  $busnessType->update($busnessTypeData);
        return $updatedBusinessType;
    }
}
