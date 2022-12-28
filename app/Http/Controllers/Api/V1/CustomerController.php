<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\v1\CustomerRequest;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\Collections\AddressCollection;
use App\Http\Resources\v1\Collections\ContactCollection;
use App\Http\Resources\v1\Collections\CustomerCollection;
use App\Http\Resources\v1\ContactResource;
use App\Http\Resources\v1\CustomerResource;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;


class CustomerController extends Controller
{

    use ApiResponse, ApiFilter;

    //get customer list
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Customer::where('account_id', $this->account_id)->with('primaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses');
        $this->dateRangeQuery($request, $query, 'portal_customers.created_at');
        $customers=$this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new CustomerCollection($customers));
    }

     //get single customer
     public function show($id)
     {
         $customer = Customer::with('PrimaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->where('account_id', Auth::user()->account_id)->find($id);
         if($customer){
             return $this->success(new CustomerResource($customer));
         }else{
             return $this->error('Data Not Found',404);
         } 
     }

     //get addresses by id
     public function getAddresses($customer_id){
       // return $customer_id;
        
        $addresses['ship_address']=Address::where('ref_object_key',Address::$ref_customer_key)->where('ref_id',$customer_id)->where('is_ship_address',1)->where('account_id', Auth::user()->account_id)->first();
        $addresses['bill_address']=Address::where('ref_object_key',Address::$ref_customer_key)->where('ref_id',$customer_id)->where('is_bill_address',1)->where('account_id', Auth::user()->account_id)->first();
        $addresses['other_addresses']=Address::where('ref_object_key',Address::$ref_customer_key)->where('ref_id',$customer_id)->where('is_bill_address',0)->where('account_id', Auth::user()->account_id)->where('is_ship_address',0)->get();
        
        if((empty($addresses['ship_address']))  && (empty($addresses['bill_address'])) && (count($addresses['other_addresses'])==0 )){
            return $this->error('Data Not Found',404);
        }else{
            return $this->success($addresses);
           
        } 
    }
    //get contacts by id
    public function getContacts($customer_id){
        //return $customer_id;
        $contacts['primary_contact']=Contact::where('ref_object_key',Address::$ref_customer_key)->where('ref_id',$customer_id)->where('is_primary_contact',1)->where('account_id', Auth::user()->account_id)->first();
        $contacts['other_contacts']=Contact::where('ref_object_key',Address::$ref_customer_key)->where('ref_id',$customer_id)->where('is_primary_contact',0)->where('account_id', Auth::user()->account_id)->get();
        //contact
       //return ($contacts['other_contacts']);
      
        if(empty($contacts['primary_contact']) && (count($contacts['other_contacts'])==0)){
            return $this->error('Data Not Found',404);
        }else{
            return $this->success($contacts);
           
        } 
    }

 //create customer
    public function create(CustomerRequest $request, $customer_id = '')
    {
        //return $request;
        $customerData = [
            'customer_type' => isset($request['customer_type']) ? $request['customer_type'] : 1,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : null,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : null,
            'website' => isset($request['website']) ? $request['website'] : null,
            'tax_name' => isset($request['tax_name']) ? $request['tax_name'] : 0,
            'tax_rate' => isset($request['tax_rate']) ? $request['tax_rate'] : 0,
            'currency' => isset($request['currency']) ? $request['currency'] : 0,
            'image' => isset($request['image']) ? $request['image'] : null,
            'payment_terms' => isset($request['payment_terms']) ? $request['payment_terms'] : 0,
            'copy_bill_address' => isset($request['copy_bill_address']) ? $request['copy_bill_address'] : 0,
            'created_by' => Auth::user()->id,
            'account_id' => Auth::user()->account_id
        ];
            DB::beginTransaction();
            try {
                $customer=Customer::create($customerData);
                DB::commit();
                return $this->success(new CustomerResource($customer),201);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
            }
        
    }
    //update customer
    public function update(CustomerRequest $request,$id)
        {
            //return $request;
            $customer=Customer::where('account_id', Auth::user()->account_id)->find($id);
            if($customer){
                DB::beginTransaction();
                try {
                    $customer->update([
                        'customer_number'=>isset($request['customer_number']) ? $request['customer_number'] : $customer->customer_number,
                        'display_name'=>isset($request['display_name']) ? $request['display_name'] : $customer->display_name,
                        'customer_type'=>isset($request['customer_type']) ? $request['customer_type'] : $customer->customer_type,
                        'copy_bill_address'=>isset($request['copy_bill_address']) ? $request['copy_bill_address'] : $customer->copy_bill_address,
                        'company_name'=>isset($request['company_name']) ? $request['company_name'] : $customer->company_name,
                        'website'=>isset($request['website']) ? $request['website'] : $customer->website,
                        'tax_rate'=>isset($request['tax_rate']) ? $request['tax_rate'] : $customer->tax_rate,
                        'currency'=>isset($request['currency']) ? $request['currency'] : $customer->currency,
                        'image'=>isset($request['image']) ? $request['image'] : $customer->image,
                        'payment_terms'=>isset($request['payment_terms']) ? $request['payment_terms'] : $customer->payment_terms,
                        'modified_by'=>Auth::user()->id,
                      
                    ]);
                    DB::commit();
                   return $this->success(new CustomerResource($customer),200);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->error($e->getMessage(), 200);
                }
                
            }else{
                return $this->error('Data Not Found',200); 
            }
            
                
        }
 //store customer with address and contact
    public function store(CustomerRequest $request)
    {

        $customerData = [
            'customer_type' => isset($request['customer_type']) ? $request['customer_type'] : 1,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : null,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : null,
            'website' => isset($request['website']) ? $request['website'] : null,
            'tax_name' => isset($request['tax_name']) ? $request['tax_name'] : 0,
            'tax_rate' => isset($request['tax_rate']) ? $request['tax_rate'] : 0,
            'currency' => isset($request['currency']) ? $request['currency'] : 0,
            'image' => isset($request['image']) ? $request['image'] : null,
            'payment_terms' => isset($request['payment_terms']) ? $request['payment_terms'] : 0,
            'copy_bill_address' => isset($request['copy_bill_address']) ? $request['copy_bill_address'] : 0,
            'created_by' => Auth::user()->id,
            'account_id' => Auth::user()->account_id
        ];

        DB::beginTransaction();

        try {
            $customer = Customer::create($customerData);
            $customer_id=$customer->id;
            if($customer_id>0){
                //store primary address
                if ($request->has('primary_contact')) {
                    if (!empty($request['primary_contact'])) {
                        $item =$request['primary_contact'];
                        $primaryContactData=[
                        'salutation'=>isset($item['salutation']) ? $item['salutation'] : null,
                        'first_name'=>isset($item['first_name']) ? $item['first_name'] : null,
                        'last_name'=>isset($item['last_name'])? $item['last_name'] : null,
                        'display_name'=>isset($item['display_name'])? $item['display_name'] : '',
                        'company_name'=>isset($item['company_name']) ? $item['company_name'] : null,
                        'contact_email'=>isset($item['contact_email'])? $item['contact_email'] : null,
                        'contact_work_phone'=>isset($item['contact_work_phone'])? $item['contact_work_phone'] : null,
                        'phone_number_country_code'=>isset($item['phone_number_country_code']) ? $item['phone_number_country_code'] : null,
                        'contact_mobile'=> isset($item['contact_mobile']) ? $item['contact_mobile'] : null,
                        'skype'=> isset($item['skype']) ? $item['skype'] : null,
                        'facebook'=> isset($item['facebook']) ? $item['facebook'] : null,
                        'twitter'=> isset($item['twitter']) ? $item['twitter'] : null,
                        'website'=> isset($item['website']) ? $item['website'] : null,
                        
                        'designation'=> isset($item['designation']) ? $item['designation'] : null,
                        'department'=> isset( $item['department']) ? $item['department'] : null,
                        'is_primary_contact'=> isset($item['is_primary_contact']) ? $item['is_primary_contact']:1,
                        'contact_type_id'=> isset($item['contact_type_id']) ? $item['contact_type_id']:0,
                        ];

                        $primary_contact = new Contact();
                        $primary_contact = $primary_contact->store($primaryContactData, $customer_id, Address::$ref_customer_key);
                        $return_data['primary_contact'] = $primary_contact;
                    }
                } //end primary contact

                //store other address
                if ($request->has(['other_contact'])) {
                    if (count($request['other_contact']) > 0) {
                        foreach ($request['other_contact'] as $key => $item) {
                            $otherContactData=[
                                'salutation'=>isset($item['salutation']) ?$item['salutation'] : null,
                                'first_name'=>isset($item['first_name']) ? $item['first_name'] : null,
                                'last_name'=>isset($item['last_name'])? $item['last_name'] : null,
                                'display_name'=>isset($item['display_name'])? $item['display_name'] : '',
                                'company_name'=>isset($item['company_name']) ? $item['company_name'] : null,
                                'contact_email'=>isset($item['contact_email'])? $item['contact_email'] : null,
                                'contact_work_phone'=>isset($item['contact_work_phone'])? $item['contact_work_phone'] : null,
                                'phone_number_country_code'=>isset($item['phone_number_country_code']) ? $item['phone_number_country_code'] : null,
                                'contact_mobile'=> isset($item['contact_mobile']) ? $item['contact_mobile'] : null,
                                'skype'=> isset($item['skype']) ? $item['skype'] : null,
                                'facebook'=> isset($item['facebook']) ? $item['facebook'] : null,
                                'twitter'=> isset($item['twitter']) ? $item['twitter'] : null,
                                'website'=> isset($item['website']) ? $item['website'] : null,
                                
                                'designation'=> isset($item['designation']) ? $item['designation'] : null,
                                'department'=> isset( $item['department']) ? $item['department'] : null,
                                'is_primary_contact'=> isset($item['is_primary_contact']) ? $item['is_primary_contact']:0,
                                'contact_type_id'=> isset($item['contact_type_id']) ? $item['contact_type_id']:0,
                                ];
    
                            $other_contact = new Contact();
                            $other_contact = $other_contact->store($otherContactData, $customer_id, Address::$ref_customer_key);
                            $return_data['other_contact'] = $other_contact;
                        };
                    };
                } //end other contact
                    $address = [];
                    $address_data = [];
                    //store bill address
                    if (!empty($request['bill_attention'])) {
                        $address_data['bill'] = [
                            'ref_object_key' => Address::$ref_customer_key,
                            'ref_id' => $customer_id,
                            'attention' => $request->bill_attention,
                            'country_id' => $request->bill_country,
                            'state_id' => $request->bill_state,
                            'district_id' => $request->bill_district,
                            'thana_id' => $request->bill_thana,
                            'union_id' => $request->bill_union,
                            'zipcode_id' => $request->bill_zipcode,
                            'street_address_id' => $request->bill_street_address,
                            'house' => $request->bill_house,
                            'phone' => $request->bill_phone,
                            'fax' => $request->bill_fax,
                            'is_bill_address' => 1
                        ];

                        $address = new Address();
                        $address['bill'] = $address->store($address_data['bill']);
                        $return_data['bill_address'] = $address['bill'];

                        //copy bill address to ship
                        if ($request['copy_bill_address'] == 1) {
                            $address_data['bill']['is_bill_address'] = 0;
                            $address_data['bill']['is_ship_address'] = 1;
                            $address_data['ship_address'] = $address->store($address_data['bill']);
                            $return_data['ship_address'] = $address_data['ship_address'];
                        }
                    }//end bill address

                    //store ship address
                    if (!empty($request['ship_attention'])) {
                        $address_data['ship'] = [
                            'ref_object_key' => Address::$ref_customer_key,
                            'ref_id' => $customer_id,
                            'attention' => $request->ship_attention,
                            'country_id' => $request->ship_country,
                            'state_id' => $request->ship_state,
                            'district_id' => $request->ship_district,
                            'thana_id' => $request->ship_thana,
                            'union_id' => $request->ship_union,
                            'zipcode_id' => $request->ship_zipcode,
                            'street_address_id' => $request->ship_street_address,
                            'house' => $request->ship_house,
                            'phone' => $request->ship_phone,
                            'fax' => $request->ship_fax,
                            'is_ship_address' => 1

                        ];
                        $address = new Address();
                        $address['ship_address'] = $address->store($address_data['ship']);
                        $return_data['ship_address'] = $address['ship_address'];
                    }
            }
            DB::commit();
            $customer = Customer::with('PrimaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->find($customer_id);
            return $this->success(new CustomerResource($customer),201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
           // return throw $e;
        }
    }

    //soft delete customer

    public function delete($id)
    {
        $customer=Customer::where('account_id', Auth::user()->account_id)->find($id);
        if($customer){
            $customer->destroy($id);
            return $this->success(null,200);
        }else{
            return $this->error('Data Not Found',201);
        };

    }
}
