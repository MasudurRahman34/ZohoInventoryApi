<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BillRequest;
use App\Http\Resources\v1\BillResource;
use App\Http\Resources\v1\Collections\BillCollection;
use App\Http\Services\V1\BillService;
use App\Http\Services\V1\CalculateProductPriceService;
use App\Models\Bill;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    use ApiResponse, ApiFilter;
    private $billService;
    private $calculateProductPrice;
    public function __construct(BillService $billService = null, CalculateProductPriceService $calculateProductPrice)
    {
        $this->billService = $billService;
        $this->calculateProductPrice = $calculateProductPrice;
    }
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Bill::with(['billItems', 'receiverAddress', 'senderAddress', 'media', 'payments']);
        $this->dateRangeQuery($request, $query, 'bills.created_at');
        $this->filterBy($request, $this->query);
        $bill = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new BillCollection($bill));
    }

    public function store(BillRequest $request)

    {


        $billRequest = $request->validated();
        $billRequest = $this->calculateProductPrice->billPrice($billRequest);
        $billRequest['user_ip'] = $request->ip();

        try {
            DB::beginTransaction();
            $newBill = $this->billService->store($billRequest);
            if ($newBill) {
                if (isset($request['sender'])) {  //insert sender information
                    $newSenderAddress = $this->billService->billAddress($request['sender'], 'sender', $newBill);
                }
                if (isset($request['receiver'])) { //insert receiver information
                    $newRecieverAddress = $this->billService->billAddress($request['receiver'], 'receiver', $newBill);
                }
            }

            DB::commit();
            $newBill = Bill::with(['billItems', 'receiverAddress', 'senderAddress', 'media'])->where('id', $newBill->id)->first();
            return $this->success($newBill);
        } catch (\Throwable $th) {
            DB::rollBack();
            return throw $th;
        }
    }

    public function update(BillRequest $request, $shortCode)
    {
        try {
            DB::beginTransaction();
            $bill = Bill::with(['billItems', 'receiverAddress', 'senderAddress', 'media'])->where('short_code', $shortCode)->first();

            if (!$bill) {
                throw new Exception("Data Not Found", 404);
            }

            $billRequest = $request->validated();
            $billRequest = $this->calculateProductPrice->billPrice($billRequest);
            $billRequest['user_ip'] = $request->ip(); //at first step calculation invoice
            $updatedBill = $this->billService->update($billRequest, $bill);

            if ($updatedBill) {

                if (isset($request['sender'])) {  //update sender information
                    if (!\is_null($bill['senderAddress'])) {
                        $newSenderAddress = $this->billService->updateBillAddress($request['sender'], 'sender', $bill['senderAddress'], $updatedBill);
                    }
                }
                if (isset($request['receiver'])) { //update receiver information

                    if (!\is_null($bill['receiverAddress'])) {
                        $updateRecieverAddress = $this->billService->updateBillAddress($request['receiver'], 'receiver', $bill['receiverAddress'], $updatedBill,);
                    }
                }
            }

            DB::commit();
            $updatedBill = Bill::with(['billItems', 'receiverAddress', 'senderAddress', 'media'])->where('short_code', $shortCode)->first();
            return $this->success($updatedBill);

            // $invoice->delete();

        } catch (\Exception $th) {
            //return $th->getCode();
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }

    public function show($uuid)
    {
        $bill = Bill::Uuid($uuid)->with(['billItems', 'receiverAddress', 'senderAddress', 'media'])->first();
        if ($bill) {
            try {

                return $this->success(new BillResource($bill));
            } catch (\Exception $th) {
                DB::rollBack();
                return $this->error($th->getMessage(), 422);
            }
        }

        return $this->error("Data Not Found", 422);
    }

    public function delete($uuid)
    {
        $bill = Bill::Uuid($uuid)->first();
        if ($bill) {
            try {
                DB::beginTransaction();
                $bill->billItems()->delete();
                $bill->receiverAddress()->delete();
                $bill->senderAddress()->delete();
                $bill->media()->delete();
                $bill->payment()->delete();
                $bill->delete();
                DB::commit();
                return $this->success();
            } catch (\Exception $th) {
                DB::rollBack();
                return $this->error($th->getMessage(), 422);
            }
        }

        return $this->error("Data Not Found", 422);
    }
}
