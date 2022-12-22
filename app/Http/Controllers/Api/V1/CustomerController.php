<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\v1\CustomerRequest;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\CustomerResource;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Customers;
use App\Models\Customer;
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

    public function create(Request $request, $customer_id = '')
    {
        //return $request;
        $validator = Validator::make($request->all(), Customers::$rules);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 200);
        } else {
            DB::beginTransaction();
            try {
                $customer = Customers::create(
                    [

                        'customer_type' => $request['customer_type'],
                        'display_name' => $request['display_name'],
                        'company_name' => $request['company_name'],
                        'website' => $request['website'],
                        'tax_rate' => $request['tax_rate'],
                        'currency' => $request['currency'],
                        'payment_terms' => $request['payment_terms'],
                        'copy_bill_address' => isset($request['copy_bill_address']) ? $request['copy_bill_address'] : 0,
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
        $customer = Customers::where('account_id', Auth::user()->account_id)->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($customer);
    }
    public function customer($id)
    {

        //$this->setFilterProperty($request);
        $customer = Customers::find($id);
        return $this->success($customer);
    }

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

            return response()->json([
                'status' => true,
                'message' => "Customer Created successfully!",
                'data' => new CustomerResource($customer)
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            //return $this->error($e->getMessage(), 200);
            return throw $e;
        }


        /*
        $return_data = [];
        $validator = Validator::make($request->all(), Customers::$rules);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 200);
        } else {
            DB::beginTransaction();
            try {

                $customer = new Customers();
                $customer->customer_type = $request['customer_type'];
                $customer->display_name = $request['display_name'];
                $customer->company_name = isset($request['company_name']) ? $request['company_name'] : null;
                $customer->website = isset($request['website']) ? $request['website'] : null;
                $customer->tax_rate = isset($request['tax_rate'])  ? $request['tax_rate'] : null;
                $customer->currency = isset($request['currency']) ? $request['currency'] : null;
                $customer->image = isset($request['image']) ? $request['image'] : null;
                $customer->payment_terms = isset($request['payment_terms']) ?: 0;
                $customer->copy_bill_address = isset($request['copy_bill_address']) ?: 0;
                $customer->save();

                $customer_id = $customer->id;


                //Store primary contact
                $return_data['customer'] = $customer;

                if ($customer_id > 0) {
                    if ($request->has('primary_contact')) {
                        if (!empty($request['primary_contact'])) {

                            $primary_contact = new Contact();


                            $primary_contact = $primary_contact->create($request['primary_contact'], $customer_id, Address::$ref_customer_key);
                            $return_data['primary_contact'] = $primary_contact;
                        }
                    }

                    //Store other contact
                    if ($request->has(['other_contact'])) {
                        if (count($request['other_contact']) > 0) {
                            foreach ($request['other_contact'] as $key => $item) {
                                $other_contact = new Contact();
                                $other_contact = $other_contact->create($item, $customer_id, Address::$ref_customer_key);
                                $return_data['other_contact'] = $other_contact;
                            };
                        };
                    }
                    $address = [];
                    $address_data = [];
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
                        $address['ship_address'] = $address->create($address_data['ship']);
                        $return_data['ship_address'] = $address['ship_address'];
                    }
                }

                DB::commit();
                return $this->success($return_data);
                //return $this->success($address_data);
            } catch (\Throwable $e) {
                DB::rollBack();
                //return $this->error($e->getMessage(), 200);
                return throw $e;
            }
        }
        */
    }
}
