<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\Customers;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
   
    use ApiResponse, ApiFilter;
    
    public function updateOrCreate(Request $request, $customer_id=''){
        //return $request;
        $validator= Validator::make($request->all(), Customers::$rules);
        if ($validator->fails()) {
            return $this->error($validator->errors(),200);
        }else{
            DB::beginTransaction();
            try {
                $customer = Customers::updateOrCreate(
                    ['id' => $customer_id],
                    [
                        
                        'contactId' => $request['contactId'],
                        'customer_type' => $request['customer_type'],
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
                return $this->success($customer);
               
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
    public function customers(Request $request)
    {
        $this->setFilterProperty($request);
        $supplier=Customers::where('account_id',Auth::user()->account_id)->orderBy($this->column_name,$this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($supplier);
        
    }
    public function customer($id)
    {
        
        //$this->setFilterProperty($request);
        $supplier=Customers::find($id);
        return $this->success($supplier);
        
    }
}
