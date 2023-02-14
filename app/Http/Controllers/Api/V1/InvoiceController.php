<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\publicInvoiceRequest;
use App\Http\Services\V1\CalculateProductPriceService;
use App\Http\Services\V1\InvoiceService;
use App\Models\Invoice;
use App\Notifications\V1\InvoiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

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
    public function createPublicInvoice(publicInvoiceRequest $request)
    {
        $request = $request->all();
        // return $request;
        $request = $this->calculateProductPriceService->invoicePrice($request);
        try {
            DB::beginTransaction();
            $newInvoice = $this->invoiceService->store($request);
            if ($newInvoice) {
                if (isset($request['sender'])) {
                    $newSenderAddress = $this->invoiceService->invoiceAddress($request['sender'], 'sender', $newInvoice);
                }
                if (isset($request['receiver'])) {
                    $newRecieverAddress = $this->invoiceService->invoiceAddress($request['receiver'], 'receiver', $newInvoice);
                }

                $this->createInvoicePdf($newInvoice->shortCode);
            }
            DB::commit();
            $this->createInvoicePdf($newInvoice->shortCode);
            DB::commit();
            $newInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->find($newInvoice->id);

            return $this->success($newInvoice);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }

    public function publicShow($shortCode)
    {
        $invoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->where('short_code', $shortCode)->first();
        if ($invoice) {
            return $this->success($invoice);
        }
        return $this->error("Data Not Found", 404);
    }
    public function createInvoicePdf($shortCode)
    {


        $newInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->where('short_code', $shortCode)->first();
        // return \view('backend.pdf.invoice', ['invoice' => $newInvoice]);
        // $renderingData = $newInvoice->toArray();

        $save_pdf_path = base_path('public/uploads/invoice/public/' . date("Ym"));
        if (!File::isDirectory($save_pdf_path)) {
            File::makeDirectory($save_pdf_path, 0777, true, true);
        }
        try {
            $pdf = App::make('dompdf.wrapper');
            $pdf =  $pdf->loadView('backend.pdf.invoice', ['invoice' => $newInvoice]);
            // ->setPaper('a4', 'portrait')
            // ->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf->save($save_pdf_path . '/' . $shortCode . '.pdf');
            $link = env('APP_URL') . '/' . 'uploads/invoice/public/' . date("Ym") . '/' . $shortCode . '.pdf';
            $newInvoice->update(['pdf_link' => $link]);
            return $newInvoice;
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 422);
        }
    }

    // public function notification($shortCode)

    // {
    //     try {
    //         $invoice = Invoice::with(['invoiceItems', 'recieverAddress', 'senderAddress'])->where('short_code', $shortCode)->first();
    //         Notification::route('mail', 'mohammadmasud34@gmail.com')->notify(new InvoiceNotification($invoice));
    //         return $this->success('send');
    //     } catch (\Throwable $th) {
    //         return $this->error('not send', $th->getCode());
    //     }
    // }
}
