<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PaymentRequest;
use App\Http\Services\V1\PaymentService;
use App\Models\Payment;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        return $this->success(Payment::Paginate(20)->withQueryString());
    }

    public function store(PaymentRequest $request, PaymentService $paymentService)
    {
        $paymentRequest = $request->validated();
        try {
            DB::beginTransaction();
            $newPayment = $paymentService->store($paymentRequest);
            DB::commit();
            return $this->success($newPayment);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }


    public function show($id)
    {
        try {
            $payment = Payment::find($id);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    public function update(PaymentRequest  $request, $id)
    {

        $payment = Payment::find($id);
        $paymentRequest = $request->Validated();
        if ($payment) {
            try {
                DB::beginTransaction();
                $payment->update($request->toArray());
                Db::commit();
                return $this->success($paymentRequest);
            } catch (\Exception $th) {
                return $this->error($th->getMessage(), 422);
            }
        }
        return $this->error("Data Not Found", 404);
    }


    public function destroy($id)
    {
        $payment = Payment::find($id);

        if ($payment) {
            try {
                DB::beginTransaction();
                $payment->delete();
                Db::commit();
                return $this->success(null);
            } catch (\Exception $th) {
                return $this->error($th->getMessage(), 422);
            }
        }
        return $this->error("Data Not Found", 404);
    }
}
