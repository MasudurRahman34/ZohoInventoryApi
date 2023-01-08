<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AddressRequest;
use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\Collections\AddressCollection;
use App\Http\Services\AddressService;
use App\Models\Address;
use App\Models\GlobalAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    use ApiFilter, ApiResponse;
    protected $addressService;
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Address::where('account_id', Auth::user()->account_id);
        $this->dateRangeQuery($request, $query, 'created_at');
        $addresses = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return new AddressCollection($addresses);
    }
    public function show($id)
    {
        $address = Address::where('account_id', Auth::user()->account_id)->find($id);
        if ($address) {
            return $this->success(new AddressResource($address));
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
    public function create(AddressRequest $request)
    {



        if ($request['source'] === 'supplier') {
            $ref_object_key = Address::$ref_supplier_key;
        } elseif ($request['source'] === 'customer') {
            $ref_object_key = Address::$ref_customer_key;
        } elseif ($request['source'] === 'user') {
            $ref_object_key = Address::$ref_user_key;
        } else {
            $message['source'][] = "The source value deos not match.";
            return $this->error($message, 422);
        }

        $request->merge(['ref_object_key' => $ref_object_key]);
        DB::beginTransaction();
        try {
            $addressResponse = $this->addressService->store($request);

            DB::commit();
            return $this->success(new AddressResource($addressResponse));
            //return $addressResponse;
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
        }
    }
    public function update(AddressRequest $request, $addressId)
    {

        $address = Address::where('account_id', Auth::user()->account_id)->find($addressId);
        if ($address) {
            if ($request['source'] == 'supplier') {
                $ref_object_key = Address::$ref_supplier_key;
            } elseif ($request['source'] == 'customer') {
                $ref_object_key = Address::$ref_customer_key;
            } elseif ($request['source'] == 'user') {
                $ref_object_key = Address::$ref_user_key;
            } else {
                $message['source'][] = "The source value deos not match.";
                return $this->error($message, 422);
            }
            $request->merge(['ref_object_key' => $ref_object_key]);

            try {
                DB::beginTransaction();

                $updatedAddress = $this->addressService->update($request, $address);

                DB::commit();

                if ($updatedAddress) {
                    return $this->success(new AddressResource($address));
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
            }
        } else {
            return $this->error('Data Not Found', 200);
        }
    }
    public function delete($id)
    {
        $address = Address::where('account_id', Auth::user()->account_id)->find($id);
        if ($address) {
            $address->destroy($id);
            return $this->success(null, 200);
        } else {
            return $this->error('Data Not Found', 200);
        };
    }
}
