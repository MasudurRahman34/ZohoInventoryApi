<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Customers;
use App\Models\Location\District;
use App\Models\Location\State;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
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
        $customer=Customers::where('account_id',Auth::user()->account_id)->orderBy($this->column_name,$this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($customer);
        
    }
    public function customer($id)
    {
        
        //$this->setFilterProperty($request);
        $customer=Customers::find($id);
        return $this->success($customer);
        
    }

    public function createCustomerWithAddressContact(Request $request){
       
        //return $request['primary_contact']['salutation'];
        //$request['bill_country']=$request->has(['bill_country']) ? ($request['bill_country'] !=null ? $request['bill_country']: 0) : 0;
    //    foreach ($request['other_contact'] as $key => $value) {
    //     return $value['salutation'];
    //    }
        return $request;
        DB::beginTransaction();
        try {
            $customer_data=[
                //'contactId' => $request['contactId'],
                'customer_type' => $request['customer_type'],
                'display_name' => $request['display_name'],
                'company_name' => $request['company_name'],
                'website' => $request['website'],
                'tax_rate' => $request['tax_rate'],
                'currency' => $request['currency'],
                'payment_terms' => $request['payment_terms'],
                //'modified_by' => Auth::user()->id,
            ];

            $customer=Customers::create($customer_data);
            if(!empty($post['p_contact_first_name'])){
            
                $primary_contact_data=[
                    'ref_object_key'=>Address::$ref_customer_key,
                    'ref_id'=> $customer->id,
                    'salutation' => $request['p_contact_salutation'],
                    'first_name' => $request['p_contact_first_name'],
                    'last_name' => $request['p_contact_last_name'],
                    'email' => $request['p_contact_email'],
                    'contact_work_phone' => $request['p_contact_phone'],
                    'contact_mobile' => $request['p_contact_mobile'],
                    'skype' => $request['p_contact_skype'],
                    'facebook' => $request['p_contact_facebook'],
                    'skype' => $request['p_contact_skype'],
                    'twitter' => $request['p_contact_twitter'],
                    'designation' => $request['p_contact_designation'],
                    'department' => $request['p_contact_department'],
                    'skype' => $request['p_contact_skype'],
                    'is_primary_contact' => 1,
                ];
               
                $primary_contact=Contact::create($primary_contact_data);
            }
            $address_data=[];
            if(!empty($request['bill_attention'])){
            $address_data['bill']=[
                'ref_object_key' => Address::$ref_customer_key,
                'ref_id' => $customer->id,
                'attention' => $request['bill_attention'],
                'country_id' =>isset($request['bill_country']) || $request['bill_country'] !=null ? $request['bill_country']: 0,
                'state_id' => isset($request['bill_state']) || $request['bill_state'] !=null ? $request['bill_state'] : 0,
                'district_id' => isset($request['bill_district']) || $request['bill_district'] !=null ? $request['bill_district'] : 0,
                'thana_id' => isset($request['bill_thana']) || $request['bill_thana'] !=null ? $request['bill_thana'] : 0,
                'union_id' => isset($request['bill_union']) ||  $request['bill_union'] !=null ? $request['bill_union'] : 0,
                'zipcode_id' => isset($request['bill_zipcode']) || $request['bill_zipcode'] !=null ? $request['bill_zipcode'] : 0,
                'street_address_id' => isset($request['bill_street_address']) || $request['bill_street_address'] ? $request['bill_street_address'] : 0,
                'house' => isset($request['bill_house']) ? $request['bill_house'] : '',
                'phone' => isset($request['bill_phone']) ? $request['bill_phone'] : '',
                'fax' => isset($request['bill_fax']) ? $request['bill_fax'] : '',
                'is_bill_address' => 1
            
            ];
            //$address_data['ship'];
            $address_data['bill']['address']=json_encode($this->setAddress($address_data['bill']));
           $address_data['bill_address']=Address::create($address_data['bill']);

           if($request['copy_bill_address']==1){
                $address_data['bill']['is_bill_address']=0;
                $address_data['bill']['is_ship_address']=1;
                $address_data['ship_address']=Address::create($address_data['bill']);
           }
        }

        if(!empty($request['ship_attention'])){
            $address_data['ship']=[
                'ref_object_key' => Address::$ref_customer_key,
                'ref_id' => $customer->id,
                'attention' => $request['ship_attention'],
                'country_id' =>isset($request['ship_country']) || $request['ship_country'] !=null ? $request['ship_country']: 0,
                'state_id' => isset($request['ship_state']) || $request['ship_state'] !=null ? $request['ship_state'] : 0,
                'district_id' => isset($request['ship_district']) || $request['ship_district'] !=null ? $request['ship_district'] : 0,
                'thana_id' => isset($request['ship_thana']) || $request['ship_thana'] !=null ? $request['ship_thana'] : 0,
                'union_id' => isset($request['ship_union']) ||  $request['ship_union'] !=null ? $request['ship_union'] : 0,
                'zipcode_id' => isset($request['ship_zipcode']) || $request['ship_zipcode'] !=null ? $request['ship_zipcode'] : 0,
                'street_address_id' => isset($request['ship_street_address']) || $request['ship_street_address'] ? $request['ship_street_address'] : 0,
                'house' => isset($request['ship_house']) ? $request['ship_house'] : '',
                'phone' => isset($request['ship_phone']) ? $request['ship_phone'] : '',
                'fax' => isset($request['ship_fax']) ? $request['ship_fax'] : '',
                'is_ship_address' => 1
            
            ];
            //$address_data['ship'];
            $address_data['ship']['address']=json_encode($this->setAddress($address_data['ship']));
           $address_data['ship_address']=Address::create($address_data['ship']);
        }

        if($request->has(['contact_first_name'])){
            for($i=0 ; $i < count($request['contact_first_name']); $i++){
                $contact=new Contact();
                $contact->ref_object_key =Address::$ref_customer_key;
                $contact->ref_id =$customer->id;
                $contact->salutation =$request['contact_salutation'][$i];
                $contact->first_name =$request['first_name'][$i];
                $contact->last_name =$request['contact_last_name'][$i];
                $contact->contact_email =$request['contact_email'][$i];
                $contact->contact_work_phone =$request['contact_work_phone'][$i];
                $contact->contact_mobile =$request['contact_mobile'][$i];
                $contact->skype =$request['skype'][$i];
                $contact->designation =$request['designation'][$i];
                $contact->department =$request['department'][$i];

                $contact->save();
            }
        }

            DB::commit();
            //return $this->success($customer);
            return $this->success($address_data);
        } catch (\Throwable $e) {
            DB::rollBack();
            //return $this->error($e->getMessage(), 200);
           return throw $e;
        }
        


    }

    public function setAddress($request){
        $address['country']=Country::where('id',$request['country_id'])->select('id','countryName')->get();
        $address['state_id']=State::where('id',$request['state_id'])->select('id','state_name')->get();
        $address['district']=District::where('id',$request['district_id'])->select('id','district_name')->get();
        $address['thana']=Thana::where('id',$request['thana_id'])->select('id','thana_name')->get();
        $address['union']=Union::where('id',$request['union_id'])->select('id','union_name')->get();
        $address['zipcode']=Zipcode::where('id',$request['zipcode_id'])->select('id','zip_code')->get();
        $address['street_address']=StreetAddress::where('id',$request['street_address_id'])->select('id','street_address_value')->get();
        
        return $address;

    }
}
