<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
   
    use ApiResponse, ApiFilter;
    
    public function updateOrCreate(Request $request, $supplier_id=''){
        //return $request;
        $validator= Validator::make($request->all(), Suppliers::$rules);
        if ($validator->fails()) {
            return $this->error($validator->errors(),200);
        }else{
            DB::beginTransaction();
            try {
                $supplier = Suppliers::updateOrCreate(
                    ['id' => $supplier_id],
                    [
                        
                        'contactId' => $request['contactId'],
                        'supplier_type' => $request['supplier_type'],
                        'display_name' => $request['display_name'],
                        'company_name' => $request['company_name'],
                        'website' => $request['website'],
                        'tax_rate' => $request['tax_rate'],
                        'currency' => $request['currency'],
                        'payment_terms' => $request['payment_terms'],
                        'modified_by' => Auth::user()->id,
                    ]
                );
                DB::commit();
                return $this->success($supplier);
               
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
                
            }
      }
    }

    public function destroy($id)
    {
        //
    }
}
