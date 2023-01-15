<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\v1\CustomerRequest;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Resources\v1\Collections\CustomerCollection;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Services\V1\AddressService;
use App\Http\Services\V1\ContactService;
use App\Http\Services\V1\CustomerService;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;


class CustomerController extends Controller
{

    use ApiResponse, ApiFilter;
    protected $addressService;
    protected $contactService;
    protected $customerService;

    public function __construct(AddressService $addressService, ContactService $contactService, CustomerService $customerService)
    {
        $this->addressService = $addressService;
        $this->contactService = $contactService;
        $this->customerService = $customerService;
    }

    //get customer list
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Customer::where('account_id', $this->account_id)->with('primaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses');
        $this->dateRangeQuery($request, $query, 'portal_customers.created_at');
        $customers = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new CustomerCollection($customers));
    }

    //get single customer
    public function show($uuid)
    {
        $customer = Customer::Uuid($uuid)->with('PrimaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->where('account_id', Auth::user()->account_id)->find($id);
        if ($customer) {
            return $this->success(new CustomerResource($customer));
        } else {
            return $this->error('Data Not Found', 404);
        }
    }

    //get addresses by id
    public function getAddresses($uuid)
    {
        // return $customer_id;
        $customer = Customer::Uuid($uuid)->first();
        if ($customer) {
            $customerId = $customer->id;
            $addresses['ship_address'] = Address::where('ref_object_key', Address::$ref_customer_key)->where('ref_id', $customerId)->where('is_ship_address', 1)->where('account_id', Auth::user()->account_id)->first();
            $addresses['bill_address'] = Address::where('ref_object_key', Address::$ref_customer_key)->where('ref_id', $customerId)->where('is_bill_address', 1)->where('account_id', Auth::user()->account_id)->first();
            $addresses['other_addresses'] = Address::where('ref_object_key', Address::$ref_customer_key)->where('ref_id', $customerId)->where('is_bill_address', 0)->where('account_id', Auth::user()->account_id)->where('is_ship_address', 0)->get();

            if ((empty($addresses['ship_address']))  && (empty($addresses['bill_address'])) && (count($addresses['other_addresses']) == 0)) {
                return $this->error('Data Not Found', 404);
            } else {
                return $this->success($addresses);
            }
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
    //get contacts by id
    public function getContacts($uuid)
    {
        //return $customer_id;
        $customer = Customer::Uuid($uuid)->first();
        if ($customer) {
            $customerId = $customer->id;
            $contacts['primary_contact'] = Contact::where('ref_object_key', Address::$ref_customer_key)->where('ref_id', $customerId)->where('is_primary_contact', 1)->where('account_id', Auth::user()->account_id)->first();
            $contacts['other_contacts'] = Contact::where('ref_object_key', Address::$ref_customer_key)->where('ref_id', $customerId)->where('is_primary_contact', 0)->where('account_id', Auth::user()->account_id)->get();


            if (empty($contacts['primary_contact']) && (count($contacts['other_contacts']) == 0)) {
                return $this->error('Data Not Found', 404);
            } else {
                return $this->success($contacts);
            }
        } else {
            return $this->error('Data Not Found', 404);
        }
    }

    //create customer
    public function create(CustomerRequest $request)
    {

        DB::beginTransaction();
        try {
            $customer = $this->customerService->store($request);
            DB::commit();
            return $this->success(new CustomerResource($customer), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
        }
    }
    //update customer
    public function update(CustomerRequest $request, $uuid)
    {
        //return $request;
        $customer = Customer::Uuid($uuid)->first();

        if ($customer) {
            DB::beginTransaction();
            try {
                $customer = $this->customerService->update($request, $customer);
                DB::commit();
                return $this->success(new CustomerResource($customer), 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
            }
        } else {
            return $this->error('Data Not Found', 200);
        }
    }
    //store customer with address and contact
    public function store(CustomerRequest $request)
    {
        $return_data = [];
        DB::beginTransaction();

        try {
            $customer = $this->customerService->store($request);
            $customer_id = $customer->id;

            //store primary address
            $return_data = $customer;
            if ($customer_id > 0) {
                //store primary address
                if ($request->has('primary_contact')) {
                    if (!empty($request['primary_contact'])) {
                        $primaryContactData = $request['primary_contact'];
                        $primaryContactData['ref_object_key'] = Address::$ref_customer_key;
                        $primaryContactData['ref_id'] = $customer_id;
                        $primaryContactData['is_primary_contact'] = 1;
                        $primary_contact = $this->contactService->store($primaryContactData);
                        $return_data['primary_contact'] = $primary_contact;
                    }
                } //end primary contact

                //store other address
                if ($request->has(['other_contact'])) {
                    if (count($request['other_contact']) > 0) {
                        foreach ($request['other_contact'] as $key => $item) {
                            $otherContactData = $item;
                            $otherContactData['ref_object_key'] = Address::$ref_customer_key;
                            $otherContactData['ref_id'] = $customer_id;

                            // $other_contact = new Contact();
                            $other_contact = $this->contactService->store($otherContactData);
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
                        'is_bill_address' => 1,
                        'is_ship_address' => 0
                    ];

                    $address['bill'] = $this->addressService->store($address_data['bill']);

                    $return_data['bill_address'] = $address['bill'];

                    //copy bill address to ship
                    if ($request['copy_bill_address'] == 1) {
                        $address_data['bill']['is_bill_address'] = 0;
                        $address_data['bill']['is_ship_address'] = 1;
                        $address_data['ship_address'] = $this->addressService->store($address_data['bill']);
                        $return_data['ship_address'] = $address_data['ship_address'];
                    }
                } //end bill address

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
                        'is_ship_address' => 1,
                        'is_bill_address' => 0,

                    ];
                    $address = new Address();
                    $address['ship_address'] = $this->addressService->store($address_data['ship']);
                    $return_data['ship_address'] = $address['ship_address'];
                }
            }
            DB::commit();
            $customer = Customer::with('PrimaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->find($customer_id);
            return $this->success(new CustomerResource($customer), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
            // return throw $e;
        }
    }

    //soft delete customer

    public function delete($uuid)
    {
        $customer = Customer::Uuid($uuid)->first();
        if ($customer) {
            $customer->destroy($uuid);
            return $this->success(null, 200);
        } else {
            return $this->error('Data Not Found', 201);
        };
    }
}
