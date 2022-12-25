<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
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
    public function updateOrCreate(Request $request,$address_id=''){
        // $request;
        //return(json_encode($this->setAddress($request)));
        $validator= Validator::make($request->all(), Address::rules());
        if ($validator->fails()) {
            return $this->error($validator->errors(),200);
        }else{
            DB::beginTransaction();
            if($request['reference_table']=='supplier'){
                $ref_object_key=Address::$ref_supplier_key;
            }
            elseif($request['reference_table']=='customer'){
                $ref_object_key=Address::$ref_customer_key;
            }
            elseif($request['reference_table']=='user'){
                $ref_object_key=Address::$ref_user_key;
            }
            else{
                $ref_object_key='unknown';
            }
            try {
                $address = Address::updateOrCreate(
                    ['id' => $address_id],
                    [
                        
                        'ref_object_key' => $ref_object_key,
                        'ref_id' => $request['ref_id'],
                        'attention' => $request['attention'],
                        'country_id' => $request['country_id'],
                        'state_id' => $request['state_id'],
                        'district_id' => $request['district_id'],
                        'thana_id' => $request['thana_id'],
                        'union_id' => $request['union_id'],
                        'zipcode_id' => $request['zipcode_id'],
                        'street_address_id' => $request['street_address_id'],
                        'house' => $request['house'],
                        'phone	' => $request['phone'],
                        'fax' => $request['fax'],
                        'is_bill_address' => $request['is_bill_address'],
                        'is_ship_address' => $request['is_ship_address'],
                        'status' => $request['status'],
                        'address' => json_encode($this->setAddress($request)),
                        'modified_by' => Auth::user()->id,
                    ]
                );
                DB::commit();
                return $this->success($address);
               
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
                
            }
      }
    }

    public function setAddress(Request $request){
        $address['country']=Country::where('id',$request['country_id'])->select('id','countryName')->get();
        $address['state_id']=State::where('id',$request['state_id'])->select('id','state_name')->get();
        $address['district']=District::where('id',$request['district_id'])->select('id','district_name')->get();
        $address['thana']=Thana::where('id',$request['thana_id'])->select('id','thana_name')->get();
        $address['union']=Union::where('id',$request['union_id'])->select('id','union_name')->get();
        $address['zipcode']=Zipcode::where('id',$request['zipcode_id'])->select('id','zip_code')->get();
        $address['street_address']=StreetAddress::where('id',$request['street_address_id'])->select('id','street_address_value')->get();
        
        return $address;

    }

    public function getAll(Request $request){
        $this->setFilterProperty($request);
        $address = Address::where('account_id', Auth::user()->account_id)->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($address);
    }
}
