<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\publicInvoiceRequest;
use App\Http\Services\V1\CalculateProductPriceService;
use App\Http\Services\V1\InvoiceService;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Notifications\V1\InvoiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
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
    { //cheching existing  invoice
        //default setting
        $recieverEmail = isset($request['receiver']['email']) ? $request['receiver']['email'] : null;
        $recieverMobile = isset($request['receiver']['mobile']) ? $request['receiver']['mobile'] : null;
        $invoice_number = isset($request['invoice_number']) ? $request['invoice_number'] : null;

        //query
        $is_exist_invoice = Invoice::with(['receiverAddress' => function ($query) use ($recieverEmail, $recieverMobile) {
            $query->where('email', $recieverEmail)->orWhere('mobile', $recieverMobile);
        }])->where('user_ip', $request->ip())
            ->where('invoice_number', $invoice_number)
            ->whereDate('invoice_date', Carbon::createFromFormat('Y-m-d', $request->invoice_date))
            ->first();

        $update_is_exist_invoice = $is_exist_invoice;
        if ($is_exist_invoice) {
            $is_exist_invoice = $is_exist_invoice->toArray();
            if (!is_null($is_exist_invoice['receiver_address'])) { //return if found existing
                $download = $is_exist_invoice['download'];
                $update_is_exist_invoice->download = $download + 1; //update $download
                $update_is_exist_invoice->save();
                return $this->success($update_is_exist_invoice);
            };
        }


        $request->merge(['user_ip' => $request->ip()]); //populate user_id
        $request = $request->all();

        $request = $this->calculateProductPriceService->invoicePrice($request); //at first step calculation invoice
        try {
            DB::beginTransaction();
            $newInvoice = $this->invoiceService->store($request); //insert invoice and invoice item
            if ($newInvoice) {
                if (isset($request['sender'])) {  //insert sender information
                    $newSenderAddress = $this->invoiceService->invoiceAddress($request['sender'], 'sender', $newInvoice);
                }
                if (isset($request['receiver'])) { //insert receiver information
                    $newRecieverAddress = $this->invoiceService->invoiceAddress($request['receiver'], 'receiver', $newInvoice);
                }
            }
            $newPdf = $this->createInvoicePdf($newInvoice->short_code); //creating invoice pdf
            DB::commit();
            $newInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->find($newInvoice->id);

            return $this->success($newInvoice);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }

    public function publicShow($shortCode) //show invoice by shortcode
    {
        $invoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->where('short_code', $shortCode)->first();
        if ($invoice) {
            return $this->success($invoice);
        }
        return $this->error("Data Not Found", 404);
    }


    public function createInvoicePdf($shortCode) //creating invoice pdf
    {
        $newInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->where('short_code', $shortCode)->first();
        if ($newInvoice) {
            $renderingData = $newInvoice->toArray();
            //return view('backend.pdf.invoice', ['invoice' => $renderingData]);
            // $pdf = App::make('dompdf.wrapper');
            // $pdf =  $pdf->loadView('backend.pdf.invoice', ['invoice' => $renderingData]);
            // // ->setPaper('a4', 'portrait')
            // // ->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // return $pdf->stream();

            $save_pdf_path = base_path('public/uploads/invoice/public/' . date("Ym"));
            if (!File::isDirectory($save_pdf_path)) {
                File::makeDirectory($save_pdf_path, 0777, true, true); //making direcotry
            }
            try {
                $pdf = App::make('dompdf.wrapper');
                $pdf =  $pdf->loadView('backend.pdf.invoice', ['invoice' => $renderingData]);
                // ->setPaper('a4', 'portrait')
                // ->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                $pdf->save($save_pdf_path . '/' . $shortCode . '.pdf');

                $link = env('APP_URL') . '/' . 'uploads/invoice/public/' . date("Ym") . '/' . $shortCode . '.pdf'; //database link
                $newInvoice->update(['pdf_link' => $link]);
                return $newInvoice;
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error('Data Not Found', 404);
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

    public function update(Request $request, $shortCode)
    {

        try {
            DB::beginTransaction();
            $invoice = Invoice::where('short_code', $shortCode)->first();

            if (!$invoice) {
                throw new Exception("Data Not Found", 404);
            }

            $request->merge(['user_ip' => $request->ip()]); //populate user_id
            $request = $request->all();

            $request = $this->calculateProductPriceService->invoicePrice($request); //at first step calculation invoice
            $updatedInvoice = $this->invoiceService->update($request, $invoice);
            //return $updatedInvoice;
            if ($updatedInvoice) {

                if (isset($request['sender'])) {  //insert sender information
                    if (!\is_null($invoice['senderAddress'])) {
                        $newSenderAddress = $this->invoiceService->updateInvoiceAddress($request['sender'], 'sender', $invoice['senderAddress'], $updatedInvoice);
                    }
                }
                if (isset($request['receiver'])) { //insert receiver information
                    $newRecieverAddress = $this->invoiceService->invoiceAddress($request['receiver'], 'receiver', $updatedInvoice);
                    if (!\is_null($invoice['receiverAddress'])) {
                        $updateRecieverAddress = $this->invoiceService->updateInvoiceAddress($request['receiver'], 'receiver', $invoice['receiverAddress'], $updatedInvoice,);
                    }
                }
            }
            $newPdf = $this->createInvoicePdf($invoice->short_code);
            DB::commit();
            $updatedInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->where('short_code', $shortCode)->first();
            return $this->success($updatedInvoice);

            // $invoice->delete();

        } catch (\Exception $th) {
            //return $th->getCode();
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
        return $shortCode;
    }
}
