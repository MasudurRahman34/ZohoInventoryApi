<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\SupplierRequest;
use App\Http\Resources\v1\Collections\SupplierCollection;
use App\Http\Resources\v1\SupplierResource;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{

    use ApiResponse, ApiFilter;

    public function create(SupplierRequest $request)
    {
        //return $request;
        
        $supplierData = [
            //'supplier_number'=>$request['supplier_number'],
            'supplier_type' => isset($request['supplier_type']) ? $request['supplier_type'] : 1,
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
                $supplier=supplier::create($supplierData);
                DB::commit();
               return $this->success(new SupplierResource($supplier),201);
                //return new SupplierCollection(Supplier::paginate(10));
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
            }
    }
    

    public function delete($id)
    {
        $supplier=Supplier::find($id);
        // ->delete();
       
        if($supplier){
            $supplier->destroy($id);
            return $this->success(null,200);
        }else{
            return $this->error('Data Not Found',201);
        };

    }
    public function getAll(Request $request)
    {
        $this->setFilterProperty($request);
        $supplier = Supplier::where('account_id', Auth::user()->account_id)->with('addresses')->with('contacts')->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new SupplierCollection($supplier));
    }
    public function show($id)
    {

        //$this->setFilterProperty($request);
        $supplier = Supplier::with('addresses')->with('contacts')->find($id);
        if($supplier){
            return $this->success(new SupplierResource($supplier));
        }else{
            return $this->error('Data Not Found',404);
        }
        
    }

    public function store(SupplierRequest $request)
    {
        $return_data = [];
        $supplierData = [
            'supplier_type' => isset($request['supplier_type']) ? $request['supplier_type'] : 1,
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

                $supplier=supplier::create($supplierData);
                $supplier_id = $supplier->id;
                //store primary address
                $return_data['supplier'] = $supplier;
                if ($supplier_id > 0) {
                    if ($request->has('primary_contact')) {
                        if (!empty($request['primary_contact'])) {
                            $primaryContactData=[
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
                            'is_primary_contact'=> isset($item['is_primary_contact']) ? $item['is_primary_contact']:1,
                            'contact_type_id'=> isset($item['contact_type_id']) ? $item['contact_type_id']:0,
                            ];

                            $primary_contact = new Contact();
                            $primary_contact = $primary_contact->create($primaryContactData, $supplier_id, Address::$ref_supplier_key);
                            $return_data['primary_contact'] = $primary_contact;
                        }
                    }
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
                                $other_contact = $other_contact->create($otherContactData, $supplier_id, Address::$ref_supplier_key);
                                $return_data['other_contact'] = $other_contact;
                            };
                        };
                    }
                    $address = [];
                    $address_data = [];
                    if (!empty($request['bill_attention'])) {
                        $address_data['bill'] = [
                            'ref_object_key' => Address::$ref_supplier_key,
                            'ref_id' => $supplier_id,
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

                        //store bill address
                        $address = new Address();
                        $address['bill'] = $address->create($address_data['bill']);
                        $return_data['bill_address'] = $address['bill'];

                        //copy bill address to ship
                        if ($request['copy_bill_address'] == 1) {
                            $address_data['bill']['is_bill_address'] = 0;
                            $address_data['bill']['is_ship_address'] = 1;
                            $address_data['ship_address'] = $address->create($address_data['bill']);
                            $return_data['ship_address'] = $address_data['ship_address'];
                        }
                    }

                    //store ship address
                    if (!empty($request['ship_attention'])) {
                        $address_data['ship'] = [
                            'ref_object_key' => Address::$ref_supplier_key,
                            'ref_id' => $supplier_id,
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
                        $address['ship_address'] = $address->create($address_data['ship']);
                        $return_data['ship_address'] = $address['ship_address'];
                    }
                }

                DB::commit();
                $supplier = Supplier::with('addresses')->with('contacts')->find($supplier_id);
                return $this->success(new SupplierResource($supplier),201);
                //return $this->show($supplier_id);
                //return $this->success($address_data);
            } catch (\Throwable $e) {
                DB::rollBack();
                //return $this->error($e->getMessage(), 200);
                return throw $e;
            }
        }

        public function update(SupplierRequest $request,$id)
        {
            //return $request;
            $supplier=Supplier::find($id);
            if($supplier){
                DB::beginTransaction();
                try {
                    $supplier->update([
                        'supplier_number'=>isset($request['supplier_number']) ? $request['supplier_number'] : $supplier->supplier_number,
                        'display_name'=>isset($request['display_name']) ? $request['display_name'] : $supplier->display_name,
                        'supplier_type'=>isset($request['supplier_type']) ? $request['supplier_type'] : $supplier->supplier_type,
                        'copy_bill_address'=>isset($request['copy_bill_address']) ? $request['copy_bill_address'] : $supplier->copy_bill_address,
                        'company_name'=>isset($request['company_name']) ? $request['company_name'] : $supplier->company_name,
                        'website'=>isset($request['website']) ? $request['website'] : $supplier->website,
                        'tax_rate'=>isset($request['tax_rate']) ? $request['tax_rate'] : $supplier->tax_rate,
                        'currency'=>isset($request['currency']) ? $request['currency'] : $supplier->currency,
                        'image'=>isset($request['image']) ? $request['image'] : $supplier->image,
                        'payment_terms'=>isset($request['payment_terms']) ? $request['payment_terms'] : $supplier->payment_terms,
                        'modified_by'=>Auth::user()->id,
                      
                    ]);
                    DB::commit();
                   return $this->success(new SupplierResource($supplier),200);
                    //return new SupplierCollection(Supplier::paginate(10));
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->error($e->getMessage(), 200);
                }
                
            }
            // $supplierData = [
            //     'supplier_number'=>$request['supplier_number'],
            //     'supplier_type' => isset($request['supplier_type']) ? $request['supplier_type'] : 1,
            //     'display_name' => isset($request['display_name']) ? $request['display_name'] : null,
            //     'company_name' => isset($request['company_name']) ? $request['company_name'] : null,
            //     'website' => isset($request['website']) ? $request['website'] : null,
            //     'tax_name' => isset($request['tax_name']) ? $request['tax_name'] : 0,
            //     'tax_rate' => isset($request['tax_rate']) ? $request['tax_rate'] : 0,
            //     'currency' => isset($request['currency']) ? $request['currency'] : 0,
            //     'image' => isset($request['image']) ? $request['image'] : null,
            //     'payment_terms' => isset($request['payment_terms']) ? $request['payment_terms'] : 0,
            //     'copy_bill_address' => isset($request['copy_bill_address']) ? $request['copy_bill_address'] : 0,
            //     'created_by' => Auth::user()->id,
            //     'account_id' => Auth::user()->account_id
            // ];
            
                
        }


    
}
