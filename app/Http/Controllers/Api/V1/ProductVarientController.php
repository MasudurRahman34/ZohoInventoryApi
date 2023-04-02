<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ProductVarientRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ItemCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductVarientController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            switch ($request['source']) {
                case 'attribute':
                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('attributes')->where('account_id', Auth::guard('api')->user()->account_id);
                        $data = DB::table('attributes')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('attributes')->where('default', 'yes')->where('status', 'active')->get();
                    }

                    break;

                case 'attributeValue':
                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('attribute_values')->where('account_id', Auth::guard('api')->user()->account_id);
                        $data = DB::table('attribute_values')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('attribute_values')->where('default', 'yes')->where('status', 'active')->get();
                    }
                    break;

                case 'itemCategory':

                    if (Auth::guard('api')->check()) {
                        $accountData = DB::table('item_categories')->where('account_id', Auth::guard('api')->user()->account_id);
                        $data = DB::table('item_categories')->where('default', 'yes')->where('status', 'active')->union($accountData)->get();
                    } else {
                        $data = DB::table('item_categories')->where('default', 'yes')->where('status', 'active')->get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductVarientRequest $request)
    {
        try {
            DB::beginTransaction();
            switch ($request['source']) {
                case 'attribute':
                    $NewProductVariant = Attribute::create($request->toArray());
                    break;

                case 'attributeValue':
                    $NewProductVariant = AttributeValue::create($request->toArray());
                    break;

                case 'itemCategory':
                    $NewProductVariant = ItemCategory::create($request->toArray());
                    break;
                default:

                    throw new Exception('invalid source');
                    break;
            }
            DB::commit();
            return $this->success($NewProductVariant);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }

    public function update(ProductVarientRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            switch ($request['source']) {
                case 'itemCategory':
                    $productVariant = ItemCategory::where('default', 'no')->find($id);
                    if ($productVariant) {
                        $updateVariant = $productVariant->update($request->toArray());
                    } else {
                        return $this->error('Data Not Found', 404);
                    }
                    break;

                case 'attributeValue':
                    $productVariant = AttributeValue::where('default', 'no')->find($id);
                    if ($productVariant) {
                        $updateVariant = $productVariant->update($request->toArray());
                    } else {
                        return $this->error('Data Not Found', 404);
                    }
                    break;

                case 'attribute':
                    $productVariant = Attribute::where('default', 'no')->find($id);
                    if ($productVariant) {
                        $updateVariant = $productVariant->update($request->toArray());
                    } else {
                        return $this->error('Data Not Found', 404);
                    }
                    break;
                default:
                    throw new Exception('invalid source');
                    break;
            }
            DB::commit();
            return $this->success($productVariant->refresh());
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }
}
