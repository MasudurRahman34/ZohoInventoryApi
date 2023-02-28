<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BillRequest;
use App\Http\Services\V1\BillService;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    use ApiResponse;
    private $billService;
    public function __construct(BillService $billService = null)
    {
        $this->billService = $billService;
    }
    public function index(Request $request)
    {
        $bill = Bill::get();
        return $this->success($bill);
    }

    public function store(BillRequest $request)

    {

        $billRequest = $request->validated();
        $billRequest['user_ip'] = $request->ip();

        try {
            DB::beginTransaction();
            $newBill = $this->billService->store($billRequest);

            DB::commit();
            $newBill = Bill::with('billItems')->find($newBill->id);
            return $this->success($newBill);
        } catch (\Throwable $th) {
            DB::rollBack();
            return throw $th;
        }
    }
}
