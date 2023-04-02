<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiFilter, ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();
        $query = $this->filterBy($request, $query);
        $product = $this->query->get();
        if (count($product) > 0) {
            return ProductResource::collection($product);
        } else {
            return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
        }
    }

    public function searchBytext(Request $request, $text)
    {
        $product = DB::table('products')
            ->leftJoin('stocks', 'product_id', 'products.id')
            ->where("products.sku", 'LIKE', '%' . $text . '%')->orWhere("products.item_name", 'LIKE', '%' . $text . '%')->get(['products.id as id', 'item_name', 'sku', 'quantity_on_hand as current_stock', 'is_serialized']);
        if (count($product) > 0) {
            return $this->success($product);
        } else {
            return $this->error('Data Not Found', 404);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $product = Product::Uuid($uuid)->first();
        if ($product) {
            return $this->success(new ProductResource($product), 'product found', Response::HTTP_FOUND);
        }
        return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
