<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\WarehouseRequest;
use App\Http\Resources\v1\WarehouseResource;
use App\Models\Warehouse;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class WarehouseController extends Controller
{
    use ApiResponse, ApiFilter;

    public function index(Request $request)
    {
        $query = Warehouse::query();
        $query = $this->filterBy($request, $query);
        $warehouse = $this->query->get();
        if (count($warehouse) > 0) {
            return $this->success(WarehouseResource::collection($warehouse));
        } else {
            return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
        }
    }


    public function store(WarehouseRequest $request)
    {
        $newWarehouseRequest = $request->validated();
        try {
            DB::beginTransaction();
            $newWarehouse = Warehouse::create($newWarehouseRequest);
            DB::commit();
            return $this->success(new WarehouseResource($newWarehouse), 'warehouse created successfully', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $warehouse = WareHouse::Uuid($uuid)->first();
        if ($warehouse) {
            return $this->success(new WarehouseResource($warehouse), 'warehouse found', Response::HTTP_FOUND);
        }
        return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
    }

    public function update(WarehouseRequest $request, $uuid)
    {
        $request = $request->validated();
        $warehouse = WareHouse::Uuid($uuid)->first();
        if ($warehouse) {

            try {
                DB::beginTransaction();
                $updatedWarehouse = $warehouse->update($request);
                DB::commit();
                return $this->success(new WarehouseResource(WareHouse::Uuid($uuid)->first()), 'warehouse updated successfully', Response::HTTP_OK);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
    }


    public function destroy($uuid)
    {
        $warehouse = WareHouse::Uuid($uuid)->first();
        if ($warehouse) {
            try {
                DB::beginTransaction();
                $warehouse->delete();
                DB::commit();
                return $this->success(NULL, 'warehouse Deleted successfully', Response::HTTP_OK);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
    }
}
