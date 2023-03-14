<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TransactionHeadRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Resources\v1\TransactionHeadResource;
use App\Models\TransactionHead;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;

class TransactionHeadController extends Controller
{
    use ApiFilter, ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = TransactionHead::query();
        $this->dateRangeQuery($request, $query, 'transactions_head.created_at');
        $this->filterBy($request, $this->query);
        $transactionHead = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return TransactionHeadResource::collection($transactionHead);
    }


    public function store(TransactionHeadRequest $request)
    {
        try {
            DB::beginTransaction();
            $newTransactionHead = TransactionHead::create($request->toArray());
            DB::commit();

            return $this->success(new TransactionHeadResource($newTransactionHead), 'New Trasaction Head Created Successfully', 201);
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->error($th, 422);
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
        try {
            return $this->success(new TransactionHeadResource(TransactionHead::findOrFail($id)), 'Trasaction Head Found', 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 404);
        }
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
    public function update(TransactionHeadRequest $request, $id)
    {

        // $request = $request->validated();
        // return $request;
        try {

            $transactionHead = TransactionHead::findOrFail($id);
            DB::beginTransaction();
            $updateRequest =
                [
                    'sort' => $request->sort ? $request->sort : $transactionHead->sort,
                    'head_name' => $request->head_name ? $request->head_name : $transactionHead->head_name,
                    'type' => $request->type ? $request->type : $transactionHead->type,
                    'description' => $request->description ? $request->description : $transactionHead->description
                ];
            $updateTransactionHead = $transactionHead->update($updateRequest);
            DB::commit();
            return $this->success(new TransactionHeadResource($transactionHead->refresh()), 'Transaction Head Updated Successfully', 200);
        } catch (\Exception $th) {
            $getCode = $th->getCode() != 0 ? $th->getCode() : 422;
            return $this->error($th->getMessage(), $getCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            //code...
            $transactionHead = TransactionHead::find($id);
            if ($transactionHead) {
                DB::beginTransaction();
                $transactionHead->delete($id);
                DB::commit();
                return $this->success(\null, "Transaction Head  Deleted successfully", 200);
            }
            return $this->error('Data Not Found', 404);
        } catch (\Throwable $th) {
            $getCode = $th->getCode() != 0 ? $th->getCode() : 422;
            return $this->error($th->getMessage(), $getCode);
        }
    }
}
