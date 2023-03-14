<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\SaleRequest;
use App\Http\Resources\v1\Collections\SaleCollection;
use App\Http\Resources\v1\SaleResource;
use App\Http\Services\V1\SaleService;
use App\Http\Services\V1\SaleItemService;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    use ApiFilter, ApiResponse;
    private $saleService;
    private $saleItemService;

    public function __construct(SaleService $saleService, SaleItemService $saleItemService)
    {
        $this->saleService = $saleService;
        $this->saleItemService = $saleItemService;
    }
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Sale::with('customer')->with('saleItems');
        $this->dateRangeQuery($request, $query, 'sales_order_date');
        $sales = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new SaleCollection($sales));
    }

    public function show($uuid)
    {
        $sale = Sale::Uuid($uuid)->with('customer')->with('saleItems')->first();
        if ($sale) {
            return $this->success(new SaleResource($sale));
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
    public function store(SaleRequest $request)
    {

        return $request;
        DB::beginTransaction();
        try {
            $sale = $this->saleService->store($request);
            if ($sale) {
                if ($request->has('saleitems')) {
                    foreach ($request->saleitems as $key => $item) {
                        $item['warehouse_id'] = $request['warehouse_id'];
                        $item['sale_id'] = $sale->id;
                        $this->saleItemService->store($item);
                    }
                }
            }
            DB::commit();
            $sale = Sale::with('saleItems')->where('account_id', Auth::user()->account_id)->find($sale->id);
            return $this->success(new SaleResource($sale), '',201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
        }
    }
    public function update(SaleRequest $sale, $id)
    {
    }

    //soft delete customer
    public function delete($uuid)
    {
        $sale = Sale::Uuid($uuid)->first();
        if ($sale) {
            try {
                DB::beginTransaction();
                $sale->saleItems()->delete();
                $sale->delete();
                DB::commit();
                return $this->success(null, '',200);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error('Data Not Found', 201);
        };
    }

    public function deleteSaleItem($id)
    {
        $saleItem = SaleItem::find($id);
        if ($saleItem) {
            $saleItem->delete();
            return $this->success(null, '',200);
        } else {
            return $this->error('Data Not Found', 404);
        };
    }
}
