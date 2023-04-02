<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Location\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\LocationRequest;
use App\Models\Company;
use App\Models\CompanyCategory;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Department;
use App\Models\Designation;
use App\Models\ItemModel;
use App\Models\Location\District;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
use App\Models\Tax;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class  LocationController extends Controller
{
    use ApiResponse, ApiFilter;

    /**
     * Get state list filter by country_iso2
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function states(Request $request, $Iso2)
    {
        try {

            //Check weather filter param is correct
            if ($request->has('filter')) {
                $filters = $request->filter;
                if(!array_key_exists('country_iso2', $filters)){
                    return $this->dataNotFound();
                }
            }

            $query = State::select('id', 'country_iso2', 'country_iso3', 'state_name', 'state_slug');
            $this->filterBy($request, $query);
            $states = $this->query->get();

            if (count($states) > 0) {
                return $this->success($states);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function districts(Request $request)
    {
        try {
            //Check weather filter param is correct
            if ($request->has('filter')) {
                $filters = $request->filter;
                if(!array_key_exists('country_iso2', $filters)){
                    return $this->dataNotFound();
                }
            }

            $query = District::select('id', 'state_id', 'district_name', 'district_slug');
            $query = $this->filterBy($request, $query);
            $districts = $this->query->get();
            if (count($districts) > 0) {
                return $this->success($districts);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
    public function thanas(Request $request)
    {
        try {
            $query = Thana::select('id', 'district_id', 'thana_name', 'thana_slug');
            $query = $this->filterBy($request, $query);
            $thanas = $this->query->get();
            if (count($thanas) > 0) {
                return $this->success($thanas);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function unions(Request $request)
    {
        try {
            $query = Union::select('id', 'thana_id', 'union_name', 'union_slug');
            $query = $this->filterBy($request, $query);
            $unions = $this->query->get();
            if (count($unions) > 0) {
                return $this->success($unions);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
    public function zipcodes(Request $request)
    {
        try {
            $query = Zipcode::select('id', 'union_id', 'zip_code');
            $query = $this->filterBy($request, $query);
            $zipcodes = $this->query->get();
            if (count($zipcodes) > 0) {
                return $this->success($zipcodes);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }
    public function streetAdress(Request $request)
    {
        try {
            $query = StreetAddress::select('id', 'union_id', 'street_address_value');
            $query = $this->filterBy($request, $query);
            $streetAdress = $this->query->get();
            if (count($streetAdress) > 0) {
                return $this->success($streetAdress);
            } else {
                return $this->error("Data Not Found", 404);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function show(Request $request)
    {
        try {
            switch ($request['source']) {

                case 'state':
                    $data = State::get();
                    break;

                case 'district':

                    $data = District::get();
                    break;

                case 'thana':

                    $data = Thana::get();
                    break;

                case 'union':

                    $data = Union::get();
                    break;

                case 'zipcode':

                    $data = Zipcode::get();
                    break;
                case 'streetAddress':


                    $data = StreetAddress::get();
                    break;

                case 'designation':

                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('designations')->where('account_id', Auth::guard('api')->user()->account_id)->where('status', 'active');
                        $data = DB::table('designations')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('designations')->where('default', 'yes')->where('status', 'active')->get();
                    }
                    break;

                case 'department':

                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('departments')->where('account_id', Auth::guard('api')->user()->account_id)->where('status', 'active');
                        $data = DB::table('departments')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('departments')->where('default', 'yes')->where('status', 'active')->get();
                    }

                    break;

                case 'tax':

                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('taxes')->where('account_id', Auth::guard('api')->user()->account_id)->where('status', 'active');
                        $data = DB::table('taxes')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('taxes')->where('default', 'yes')->where('status', 'active')->get();
                    }

                    break;

                case 'currency':
                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('currencies')->where('account_id', Auth::guard('api')->user()->account_id)->where('status', 'active');
                        $data = DB::table('currencies')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('currencies')->where('default', 'yes')->where('status', 'active')->get();
                    }

                    break;
                case 'companyCategory':
                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('company_categories')->where('account_id', Auth::guard('api')->user()->account_id)->where('status', 'active');
                        $data = DB::table('company_categories')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('company_categories')->where('default', 'yes')->where('status', 'active')->get();
                    }
                    break;

                case 'company':
                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('companies')->where('account_id', Auth::guard('api')->user()->account_id)->where('status', 'active');
                        $data = DB::table('companies')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('companies')->where('default', 'yes')->where('status', 'active')->get();
                    }
                    break;

                case 'model':
                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('item_models')->where('account_id', Auth::guard('api')->user()->account_id)->where('status', 'active');
                        $data = DB::table('item_models')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('item_models')->where('default', 'yes')->where('status', 'active')->get();
                    }
                    break;

                default:
                    throw new Exception('invalid source');
                    break;
            }
            if (count($data) > 0) {
                return $this->success($data, "Data Found !", 200);
            }
            return $this->error("data Not Found", 404);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }


    public function addNew(LocationRequest $request)
    {
        try {
            $source = $request->source;

            DB::beginTransaction();
            switch ($source) {
                case 'state':
                    $country = Country::where('iso2', $request->parent['value'])->first();

                    $newStateRequest = [
                        'state_name' => $request->value,
                        'country_iso2' => $country->iso2,
                        'country_iso3' => $country->iso3,
                        'state_slug' => Str::slug($request->value),
                    ];
                    $newAddedValue = State::create($newStateRequest);

                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->state_name,
                    ];

                    break;

                case 'district':
                    $newDistrictRequest = [
                        'district_name' => $request->value,
                        'district_slug' => Str::slug($request->value),
                        'state_id' => $request->parent_id,
                    ];
                    $newAddedValue = District::create($newDistrictRequest);

                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->district_name,
                    ];
                    break;

                case 'thana':
                    $newthanaRequest = [
                        'thana_name' => $request->value,
                        'thana_slug' => Str::slug($request->value),
                        'district_id' => $request->parent_id,
                    ];
                    $newAddedValue = Thana::create($newthanaRequest);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->thana_name,
                    ];
                    break;

                case 'union':
                    $newUnionRequest = [
                        'union_name' => $request->value,
                        'union_slug' => Str::slug($request->value),
                        'thana_id' => $request->parent_id,
                    ];
                    $newAddedValue = Union::create($newUnionRequest);

                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->union_name,
                    ];
                    break;

                case 'zipcode':
                    $newZipcodeRequest = [
                        'zip_code' => $request->value,
                        'thana_id' => $request->parent_id,
                    ];

                    $newAddedValue = Zipcode::create($newZipcodeRequest);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->zip_code,
                    ];

                    break;
                case 'street-address':
                    $newStreetRequest = [
                        'street_address_value' => $request->value,
                        'union_id' => $request->parent_id,
                    ];
                    $newAddedValue = StreetAddress::create($newStreetRequest);

                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->street_address_value,
                    ];
                    break;

                case 'designation':
                    $newDesignation = [
                        'name' => $request->value,
                    ];
                    $newAddedValue = Designation::create($newDesignation);

                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->name,
                    ];
                    break;

                case 'department':
                    $newDepartment = [
                        'name' => $request->value,
                    ];
                    $newAddedValue = Department::create($newDepartment);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->name,
                    ];

                    break;

                case 'tax':
                    $newDepartment = [
                        'name' => $request->value,
                        'rate' => $request->rate,
                        'description' => $request->description,
                    ];
                    $newAddedValue = Tax::create($newDepartment);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->name,
                    ];
                    break;

                case 'currency':
                    $newDepartment = [
                        'name' => $request->value,
                        'symbol' => $request->symbol,
                        'code' => $request->code,
                        'description' => $request->description
                    ];
                    $newAddedValue = Currency::create($newDepartment);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->name,
                    ];
                    break;

                case 'companyCategory':
                    $newCompanyCategory = [
                        'name' => $request->value,
                        'status' => $request->status,

                    ];
                    $newAddedValue = CompanyCategory::create($newCompanyCategory);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->name,
                    ];
                    break;

                case 'company':
                    $newCompanyRequest = [
                        'name' => $request->value,
                        'slug' => Str::slug($request->value),
                        'company_category_id' => $request->company_category_id
                    ];
                    $newAddedValue = Company::create($newCompanyRequest);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->name,
                    ];
                    break;

                case 'model':
                    $newItemModel = [
                        'name' => $request->value,
                        'slug' => Str::slug($request->value),
                        'company_id' => $request->company_id
                    ];
                    $newAddedValue = ItemModel::create($newItemModel);
                    $responseData = [
                        'id' => $newAddedValue->id,
                        'value' => $newAddedValue->name,
                    ];
                    break;

                default:
                    throw new Exception('invalid source');
                    break;
            }
            DB::commit();
            return $this->success($responseData, "New Data Created Successfully", 201);
        } catch (\Throwable $th) {
            return $this->error($th, 422);
        }
    }
}
