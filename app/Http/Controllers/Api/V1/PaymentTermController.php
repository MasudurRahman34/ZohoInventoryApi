<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PaymentRequest;
use App\Http\Requests\v1\PaymentTermRequest;
use App\Http\Resources\v1\PaymentTermResource;
use App\Models\PaymentTerm;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PaymentTermController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentTerm = PaymentTerm::withoutGlobalScope(AccountScope::class)->get();
        try {
            return $this->success(PaymentTermResource::collection($paymentTerm));
        } catch (Exception $th) {
            return $this->error($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
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
    public function store(PaymentTermRequest $request)
    {
        $paymentRequest = $request->validated();

        try {
            DB::beginTransaction();
            $newPaymentTerm = PaymentTerm::create($paymentRequest);
            DB::commit();
            return $this->success(new PaymentTermResource($newPaymentTerm), "New Payment Term Has Been Created Successfully !", Response::HTTP_CREATED);
        } catch (Exception $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentTerm = PaymentTerm::withoutGlobalScope(AccountScope::class)->find($id);
        if ($paymentTerm) {
            try {
                return $this->success(new PaymentTermResource($paymentTerm, "Payment Terms Found"), Response::HTTP_OK);
            } catch (Exception $th) {
                return $this->error($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
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
    public function update(PaymentTermRequest $request, $id)
    {
        $paymentRequest = $request->validated();
        $paymentTerm = PaymentTerm::find($id);
        $updatePaymentTerm = $paymentTerm;
        if ($paymentTerm) {
            try {
                DB::beginTransaction();
                $newPaymentTerm = $paymentTerm->update($paymentRequest);
                DB::commit();
                return $this->success(new PaymentTermResource($updatePaymentTerm->refresh(), "Payment Term Updated SuccessFully"), Response::HTTP_OK);
            } catch (Exception $th) {
                return $this->error($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentTerm = PaymentTerm::find($id);
        if ($paymentTerm) {
            try {
                DB::beginTransaction();
                $paymentTerm->delete();
                DB::commit();
                return $this->success(NULL, "Payment Term Deleted SuccessFully", Response::HTTP_OK);
            } catch (Exception $th) {
                return $this->error($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        return $this->error("Data Not Found", Response::HTTP_NOT_FOUND);
    }
}
