<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AddressRequest;
use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\Collections\AddressCollection;
use App\Models\Address;
use App\Models\Country;
use App\Models\Location\District;
use App\Models\Location\State;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    use ApiFilter, ApiResponse;

    public function index(Request $request){
        $this->setFilterProperty($request);
        $query = Address::where('account_id', Auth::user()->account_id);
        $this->dateRangeQuery($request, $query, 'created_at');
        $addresses=$this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return new AddressCollection($addresses);
    }
    public function show($id){
        $address = Address::where('account_id', Auth::user()->account_id)->find($id);
         if($address){
             return $this->success(new AddressResource($address));
         }else{
             return $this->error('Data Not Found',404);
         } 
    }
    public function create(AddressRequest $request){
     
            
            if($request['source']==='supplier'){
                $ref_object_key=Address::$ref_supplier_key;
            }
            elseif($request['source']==='customer'){
                $ref_object_key=Address::$ref_customer_key;
            }
            elseif($request['source']==='user'){
                $ref_object_key=Address::$ref_user_key;
            }
            else{
                $message['source'][]="The source value deos not match.";
                return $this->error($message,422);
            }
            DB::beginTransaction();
            try {
                $address_data = [
                    'ref_object_key' => $ref_object_key,
                    'ref_id' => $request->ref_id,
                    'attention' => $request->attention,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'district_id' => $request->district_id,
                    'thana_id' => $request->thana_id,
                    'union_id' => $request->union_id,
                    'zipcode_id' => $request->zipcode_id,
                    'street_address_id' => $request->street_address_id,
                    'house' => $request->house,
                    'phone' => $request->phone,
                    'fax' => $request->fax,
                    'is_bill_address' =>$request->is_bill_address,
                    'is_ship_address' =>$request->is_ship_address,
                    'status' =>$request->status,
                   
                ];

                $address = new Address();
                $addressResponse= $address->store($address_data);
                
                DB::commit();
                return $this->success(new AddressResource($addressResponse));
               
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
                
            }
      
    }
    public function update(AddressRequest $request,$address_id){
     
        $address=Address::where('account_id', Auth::user()->account_id)->find($address_id);
        if($address){
            if($request['source']=='supplier'){
                $ref_object_key=Address::$ref_supplier_key;
            }
            elseif($request['source']=='customer'){
                $ref_object_key=Address::$ref_customer_key;
            }
            elseif($request['source']=='user'){
                $ref_object_key=Address::$ref_user_key;
            }
            else{
                $message['source'][]="The source value deos not match.";
                return $this->error($message,422);
            }
            $setaddress = new Address();
            $address_data=[
                'ref_object_key' => $ref_object_key,
                'ref_id' => isset($request->ref_id) ? $request->ref_id : $address->ref_id,
                'attention' => isset($request->attention) ? $request->attention :$address->attention,
                'country_id' => isset($request->country_id) ? $request->country_id :$address->country_id,
                'state_id' => isset($request->state_id) ? $request->state_id:$address->state_id,
                'district_id' => isset($request->district_id) ? $request->district_id :$address->district_id,
                'thana_id' => isset($request->thana_id) ? $request->thana_id : $address->thana_id,
                'union_id' => isset($request->union_id) ? $request->union_id  : $address->union_id,
                'zipcode_id' => isset($request->zipcode_id) ? $request->zipcode_id :$address->zipcode_id,
                'street_address_id' => isset($request->street_address_id)? $request->street_address_id  :$address->street_address_id,
                'house' => isset($request->house) ? $request->house :$address->house,
                'phone' => isset($request->phone)  ? $request->phone:$address->phone,
                'fax' => isset($request->fax) ? $request->fax :$address->fax,
                'is_bill_address' =>isset($request->is_bill_address) ? $request->is_bill_address :$address->is_bill_address,
                'is_ship_address' =>isset($request->is_ship_address) ? $request->is_ship_address :$address->is_ship_address,
                'status' =>isset($request->status) ? $request->status :$address->status,
                'modified_by' =>Auth::user()->id,
            
            ];
            
            $address_data['full_address']=$setaddress->setAddress($address_data);
            

           // return $address_data;
            try {
                DB::beginTransaction();
                $address->update($address_data);
                //$addressResponse= $address->create($address_data);
                
                DB::commit();
                return $this->success(new AddressResource($address));
            
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
                
            }
        }else{
            return $this->error('Data Not Found',200); 
        }
  
    }
    public function delete($id)
    {
        $address=Address::where('account_id', Auth::user()->account_id)->find($id);
        if($address){
            $address->destroy($id);
            return $this->success(null,200);
        }else{
            return $this->error('Data Not Found',200);
        };

    }

    
}
