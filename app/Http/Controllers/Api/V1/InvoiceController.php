<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\publicInvoiceRequest;
use App\Http\Services\V1\CalculateProductPriceService;
use App\Http\Services\V1\InvoiceService;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    use ApiResponse;
    private $invoiceService;
    private $calculateProductPriceService;
    public function __construct(InvoiceService $invoiceService, CalculateProductPriceService $calculateProductPriceService)
    {
        $this->invoiceService = $invoiceService;
        $this->calculateProductPriceService = $calculateProductPriceService;
    }
    public function createPublicInvoice(Request $request)
    {
        $request = $request->all();
        $request = $this->calculateProductPriceService->invoicePrice($request);
        try {
            DB::beginTransaction();
            $newInvoice = $this->invoiceService->store($request);
            if ($newInvoice) {
                if (isset($request['sender'])) {
                    $newSenderAddress = $this->invoiceService->invoiceAddress($request['sender'], 'sender', $newInvoice->id);
                }
                if (isset($request['reciever'])) {
                    $newRecieverAddress = $this->invoiceService->invoiceAddress($request['reciever'], 'reciever', $newInvoice->id);
                }
            }
            DB::commit();

            $newInvoice = Invoice::with(['invoiceItems', 'recieverAddress', 'senderAddress'])->find($newInvoice->id);
            return $this->success($newInvoice);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }

    public function publicShow($shortCode)
    {
        $invoice = Invoice::with(['invoiceItems', 'recieverAddress', 'senderAddress'])->where('short_code', $shortCode)->first();
        if ($invoice) {
            return $this->success($invoice);
        }
        return $this->error("Data Not Found", 404);
    }
}
