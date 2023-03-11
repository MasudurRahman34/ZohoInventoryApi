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
use App\Http\Services\V1\AddressService;
use App\Http\Services\V1\ContactService;
use App\Http\Services\V1\SupplierService;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Supplier;

class SupplierController extends Controller
{

    use ApiResponse, ApiFilter;

    protected $addressService;
    protected $contactService;
    protected $supplierService;

    public function __construct(AddressService $addressService, ContactService $contactService, SupplierService $supplierService)
    {
        $this->addressService = $addressService;
        $this->contactService = $contactService;
        $this->supplierService = $supplierService;
    }
    //get supplier list
    public function index(Request $request)
    {

        //return $request->filter['display_name'];
        $this->setFilterProperty($request);
        $query = Supplier::
            //withoutGlobalScopes();
            // ->with(['primaryContact'=>fn($query)=>$query
            //     ->where('display_name', 'LIKE', '%' . $request->filter['display_name'] . '%')
            //    ])
            with((['primaryContact' => function ($query) {
                //$query->where('display_name', 'LIKE', '%' . 'chonchol chowdhuri' . '%');
                //$filter['display_name']='chonchol chowdhuri'
                //$this->filterBy($request,$query);
            }]))
            ->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->with('purchases');
        $this->dateRangeQuery($request, $query, 'portal_suppliers.created_at');
        $this->filterBy($request, $this->query);
        $suppliers = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success(new SupplierCollection($suppliers));
    }

    //get single supplier
    public function show($uuid)
    {
        // $supplier = Supplier::with('PrimaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->find($id);
        $supplier = Supplier::Uuid($uuid)->with('PrimaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->first();
        if ($supplier) {
            return $this->success(new SupplierResource($supplier));
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
    //get addresses by id
    public function getAddresses($uuid)
    {
        //=return $id;
        //$supplierAddresses = Supplier::with('shipAddress')->with('billAddress')->with('otherAddresses')->where('account_id', Auth::user()->account_id)->find($id);
        $supplier = Supplier::Uuid($uuid)->first();
        if ($supplier) {
            $supplierId = $supplier->id;
            $addresses['ship_address'] = Address::where('ref_object_key', Address::$ref_supplier_key)->where('ref_id', $supplierId)->where('is_ship_address', 1)->first();
            $addresses['bill_address'] = Address::where('ref_object_key', Address::$ref_supplier_key)->where('ref_id', $supplierId)->where('is_bill_address', 1)->first();
            $addresses['other_addresses'] = Address::where('ref_object_key', Address::$ref_supplier_key)->where('ref_id', $supplierId)->where('is_bill_address', 0)->where('is_ship_address', 0)->get();
            if ((empty($addresses['ship_address']))  && (empty($addresses['bill_address'])) && (count($addresses['other_addresses']) == 0)) {
                return $this->error('Data Not Found', 404);
            } else {
                return $this->success($addresses);
            }
        }
    }
    //get contacts by id
    public function getContacts($uuid)
    {
        $supplier = Supplier::Uuid($uuid)->first();
        if ($supplier) {
            $supplierId = $supplier->id;
            //return $supplier_id;
            $contacts['primary_contact'] = Contact::where('ref_object_key', Address::$ref_supplier_key)->where('ref_id', $supplierId)->where('is_primary_contact', 1)->first();
            $contacts['other_contacts'] = Contact::where('ref_object_key', Address::$ref_supplier_key)->where('ref_id', $supplierId)->where('is_primary_contact', 0)->get();
            //contact
            //return ($contacts['other_contacts']);

            if (empty($contacts['primary_contact']) && (count($contacts['other_contacts']) == 0)) {
                return $this->error('Data Not Found', 404);
            } else {
                return $this->success($contacts);
            }
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
    //create supplier
    public function create(SupplierRequest $request)
    {
        DB::beginTransaction();
        try {
            $supplier = $this->supplierService->store($request);
            DB::commit();
            return $this->success(new SupplierResource($supplier), '',201);
            //return new SupplierCollection(Supplier::paginate(10));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
        }
    }

    //update supplier
    public function update(SupplierRequest $request, $uuid)
    {
        //return $request;
        $supplier = Supplier::Uuid($uuid)->first();
        if ($supplier) {
            DB::beginTransaction();
            try {
                $supplier = $this->supplierService->update($request, $supplier);
                DB::commit();
                return $this->success(new SupplierResource($supplier), '',200);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
            }
        } else {
            return $this->error('Data Not Found', 201);
        }
    }

    //store supplier with contact and addresss
    public function store(SupplierRequest $request)
    {
        $return_data = [];
        DB::beginTransaction();
        try {

            // $supplier = supplier::create($supplierData);
            $supplier = $this->supplierService->store($request);
            $supplier_id = $supplier->id;

            //store primary address
            $return_data = $supplier;
            if ($supplier_id) {
                if ($request->has('primary_contact')) {
                    if (!empty($request['primary_contact'])) {
                        $primaryContactData = $request['primary_contact'];
                        $primaryContactData['ref_object_key'] = Address::$ref_supplier_key;
                        $primaryContactData['ref_id'] = $supplier_id;
                        $primaryContactData['is_primary_contact'] = 1;
                        $primary_contact = $this->contactService->store($primaryContactData);
                        $return_data['primary_contact'] = $primary_contact;
                    }
                }

                //store other address
                if ($request->has(['other_contact'])) {
                    if (count($request['other_contact']) > 0) {
                        foreach ($request['other_contact'] as $key => $item) {
                            $otherContactData = $item;
                            $otherContactData['ref_object_key'] = Address::$ref_supplier_key;
                            $otherContactData['ref_id'] = $supplier_id;

                            // $other_contact = new Contact();
                            $other_contact = $this->contactService->store($otherContactData);
                            $return_data['other_contact'] = $other_contact;
                        };
                    };
                } //end contact

                $address = [];
                $address_data = [];
                //store bill address
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
                        'is_bill_address' => 1,
                        'is_ship_address' => 0
                    ];

                    //$address = new Address();

                    $address['bill'] = $this->addressService->store($address_data['bill']);

                    $return_data['bill_address'] = $address['bill'];

                    //copy bill address to ship
                    if ($request['copy_bill_address'] == 1) {
                        $address_data['bill']['is_bill_address'] = 0;
                        $address_data['bill']['is_ship_address'] = 1;
                        $address_data['ship_address'] =  $this->addressService->store($address_data['bill']);
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
                        'is_ship_address' => 1,
                        'is_bill_address' => 0,
                        //'global_address_edit'=> $request->global_address_edit

                    ];
                    // $address = new Address();
                    $address['ship_address'] =  $this->addressService->store($address_data['ship']);
                    $return_data['ship_address'] = $address['ship_address'];
                }
            }

            DB::commit();

            $supplier = Supplier::with('PrimaryContact')->with('otherContacts')->with('shipAddress')->with('billAddress')->with('otherAddresses')->find($supplier_id);
            return $this->success(new SupplierResource($supplier), '',201);
            //return $this->success($return_data);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 422);
            //return throw $e;
        }
    }



    //soft delete supplier
    public function delete($uuid)
    {
        $supplier = Supplier::Uuid($uuid)->first();
        if ($supplier) {
            $supplier->delete($uuid);
            return $this->success(null, 'Supplier deleted successfully!', 200);
        } else {
            return $this->error('Data Not Found', 404);
        };
    }
}
