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
                if (!array_key_exists('country_iso2', $filters)) {
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
                if (!array_key_exists('country_iso2', $filters)) {
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
            DB::beginTransaction();
            switch ($request['source']) {

                case 'state':
                    $country = Country::find($request->parent_id);
                    $newStateRequest = [
                        'state_name' => $request->name,
                        'country_iso2' => $country->iso2,
                        'country_iso3' => $country->iso3,
                        'state_slug' => Str::slug($request->name),
                        'state_name' => $request->name,
                    ];
                    $newLocation = State::create($newStateRequest);
                    break;

                case 'district':
                    $newDistrictRequest = [
                        'district_name' => $request->name,
                        'district_slug' => Str::slug($request->name),
                        'state_id' => $request->parent_id,
                    ];
                    $newLocation = District::create($newDistrictRequest);
                    break;

                case 'thana':
                    $newthanaRequest = [
                        'thana_name' => $request->name,
                        'thana_slug' => Str::slug($request->name),
                        'district_id' => $request->parent_id,
                    ];
                    $newLocation = Thana::create($newthanaRequest);
                    break;

                case 'union':
                    $newUnionRequest = [
                        'union_name' => $request->name,
                        'union_slug' => Str::slug($request->name),
                        'thana_id' => $request->parent_id,
                    ];
                    $newLocation = Union::create($newUnionRequest);
                    break;

                case 'zipcode':
                    $newZipcodeRequest = [
                        'zip_code' => $request->name,
                        'union_id' => $request->parent_id,
                    ];
                    $newLocation = Zipcode::create($newZipcodeRequest);
                    break;
                case 'streetAddress':
                    $newStreetRequest = [
                        'street_address_value' => $request->name,
                        'union_id' => $request->parent_id,
                    ];
                    $newLocation = StreetAddress::create($newStreetRequest);
                    break;

                case 'designation':
                    $newDesignation = [
                        'name' => $request->name,
                        'description' => $request->description,
                        'status' => $request->status,
                    ];
                    $newLocation = Designation::create($newDesignation);
                    break;

                case 'department':
                    $newDepartment = [
                        'name' => $request->name,
                        'description' => $request->description,
                        'status' => $request->status,
                    ];
                    $newLocation = Department::create($newDepartment);
                    break;

                case 'tax':
                    $newDepartment = [
                        'name' => $request->name,
                        'description' => $request->description,
                        'rate' => $request->rate,
                        'status' => $request->status,
                    ];
                    $newLocation = Tax::create($newDepartment);
                    break;

                case 'currency':
                    $newDepartment = [
                        'name' => $request->name,
                        'description' => $request->description,
                        'symbol' => $request->symbol,
                        'code' => $request->code,
                        'status' => $request->status,
                    ];
                    $newLocation = Currency::create($newDepartment);
                    break;

                case 'companyCategory':
                    $newCompanyCategory = [
                        'name' => $request->name,
                        'status' => $request->status,

                    ];
                    $newLocation = CompanyCategory::create($newCompanyCategory);
                    break;

                case 'company':
                    $newCompanyRequest = [
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'company_category_id' => $request->company_category_id,
                        'status' => $request->status,

                    ];

                case 'model':
                    $newItemModel = [
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'company_id' => $request->company_id,
                        'status' => $request->status,

                    ];
                    $newLocation = ItemModel::create($newItemModel);
                    break;

                default:
                    throw new Exception('invalid source');
                    break;
            }
            DB::commit();
            return $this->success($newLocation, "New Data Created Successfully", 201);
        } catch (\Throwable $th) {
            return $this->error($th, 422);
        }
    }
}
