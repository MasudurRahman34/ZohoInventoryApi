<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MediaRequest;
use App\Http\Requests\v1\publicInvoiceRequest;
use App\Http\Resources\v1\Collections\InvoiceCollection;
use App\Http\Services\V1\CalculateProductPriceService;
use App\Http\Services\V1\InvoiceService;
use App\Http\Services\V1\MediaService;
use App\Models\Attachment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Media;
use App\Models\Scopes\AccountScope;
use App\Notifications\V1\InvoiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\Node\FunctionNode;

class InvoiceController extends Controller
{
    use ApiResponse, ApiFilter;
    private $invoiceService;
    private $calculateProductPriceService;
    public function __construct(InvoiceService $invoiceService, CalculateProductPriceService $calculateProductPriceService)
    {
        $this->invoiceService = $invoiceService;
        $this->calculateProductPriceService = $calculateProductPriceService;
    }

    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        if (Auth::guard('api')->check()) {
            $query = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress', 'media']);
        } else {
            $query = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress', 'media'])->where('user_ip', $request->ip());
        }


        $this->dateRangeQuery($request, $query, 'invoices.created_at');
        $this->filterBy($request, $this->query);
        $invoice = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new InvoiceCollection($invoice));


        return $invoice;
    }

    public function createPublicInvoice(publicInvoiceRequest $request)
    {



        //cheching existing  invoice
        //default setting
        // $recieverEmail = isset($request['receiver']['email']) ? $request['receiver']['email'] : null;
        // $recieverMobile = isset($request['receiver']['mobile']) ? $request['receiver']['mobile'] : null;
        // $invoice_number = isset($request['invoice_number']) ? $request['invoice_number'] : null;

        // //query
        // $is_exist_invoice = Invoice::with(['receiverAddress' => function ($query) use ($recieverEmail, $recieverMobile) {
        //     $query->where('email', $recieverEmail)->orWhere('mobile', $recieverMobile);
        // }])->where('user_ip', $request->ip())
        //     ->where('invoice_number', $invoice_number)
        //     ->whereDate('invoice_date', Carbon::createFromFormat('Y-m-d', $request->invoice_date))
        //     ->first();

        // $update_is_exist_invoice = $is_exist_invoice;
        // if ($is_exist_invoice) {
        //     $is_exist_invoice = $is_exist_invoice->toArray();
        //     if (!is_null($is_exist_invoice['receiver_address'])) { //return if found existing
        //         $download = $is_exist_invoice['download'];
        //         $update_is_exist_invoice->download = $download + 1; //update $download
        //         $update_is_exist_invoice->save();
        //         return $this->success($update_is_exist_invoice);
        //     };
        // }


        $request->merge(['user_ip' => $request->ip()]); //populate user_id
        $request = $request->all();

        $request = $this->calculateProductPriceService->invoicePrice($request); //at first step calculation
        // return $request;

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
            $newInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress', 'media'])->find($newInvoice->id);

            return $this->success($newInvoice);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }

    public function show(Request $request, $shortCode) //show invoice by shortcode
    {



        $invoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress', 'media'])->where('short_code', $shortCode)->withoutGlobalScope(AccountScope::class)->first();

        if ($invoice) {
            return $this->success($invoice);
        }
        return $this->error("Data Not Found", 404);
    }


    public function createInvoicePdf($shortCode) //creating invoice pdf
    {

        $newInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress'])->where('short_code', $shortCode)->withoutGlobalScope(AccountScope::class)->first();
        if ($newInvoice) {
            $renderingData = $newInvoice->toArray();
            //return view('backend.pdf.invoice', ['invoice' => $renderingData]);
            // $pdf = App::make('dompdf.wrapper');
            // $pdf =  $pdf->loadView('backend.pdf.invoice', ['invoice' => $renderingData]);
            // // ->setPaper('a4', 'portrait')
            // // ->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // return $pdf->stream();

            $this->invoiceService->deleteExistingFile($newInvoice->pdf_link);

            $save_pdf_path = Invoice::$INVOICE_FILE_PATH . date("Ym");

            // return $save_pdf_path;
            if (!Storage::directoryExists($save_pdf_path)) {
                Storage::makeDirectory($save_pdf_path, 0777, true, true); //making direcotry
            }
            try {
                $pdf = App::make('dompdf.wrapper');
                $pdf =  $pdf->loadView('backend.pdf.invoice', ['invoice' => $renderingData]);
                // ->setPaper('a4', 'portrait')
                // ->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                //  $pdf->save($save_pdf_path . '/' . $shortCode . '.pdf');
                $pdf = $pdf->download()->getOriginalContent();
                $file = Storage::put($save_pdf_path . '/' . $shortCode . '.pdf', $pdf);
                $filePath = Storage::url($save_pdf_path . '/' . $shortCode . '.pdf');
                $newInvoice->update(['pdf_link' => $filePath]);
                return  $renderingData;
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error('Data Not Found', 404);
        }
    }

    public function update(publicInvoiceRequest $request, $shortCode)
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
                    // $newRecieverAddress = $this->invoiceService->invoiceAddress($request['receiver'], 'receiver', $updatedInvoice);
                    if (!\is_null($invoice['receiverAddress'])) {
                        $updateRecieverAddress = $this->invoiceService->updateInvoiceAddress($request['receiver'], 'receiver', $invoice['receiverAddress'], $updatedInvoice);
                    }
                }
            }
            $newPdf = $this->createInvoicePdf($invoice->short_code);
            DB::commit();
            $updatedInvoice = Invoice::with(['invoiceItems', 'receiverAddress', 'senderAddress', 'media'])->where('short_code', $shortCode)->first();
            return $this->success($updatedInvoice);

            // $invoice->delete();

        } catch (\Exception $th) {
            //return $th->getCode();
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }

    public function downloadInvoicePdf($shortCode)
    {
        $invoice = Invoice::where('short_code', $shortCode)->withoutGlobalScope(AccountScope::class)->first();
        if ($invoice) {

            function get_path($fileLink)
            {
                return \str_replace('/storage', '/public', $fileLink);
            }

            $fileLink = get_path($invoice->pdf_link);

            return Storage::download($fileLink);
            // return $this->success($invoice);
        }
        return $this->error("Data Not Found", 404);
    }

    // public function invoiceMedia(MediaRequest $request, MediaService $mediaService)
    // {
    //     try {
    //         DB::BeginTransaction();
    //         $request = $request->all();
    //         // foreach ($request['media'] as $key => $item) {
    //         $newMedia = $mediaService->store($request);
    //         // }

    //         DB::commit();
    //         return $this->success($newMedia);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return $this->error($th->getMessage(), 422);
    //     }
    // }


    public function destroy($shortCode)
    {

        $invoice = Invoice::where('short_code', $shortCode)->first();
        if ($invoice) {
            try {
                DB::beginTransaction();
                if ($invoice->has("senderAddress")) {
                    if (!\is_null($invoice['senderAddress']['company_logo'])) {
                        $this->invoiceService->deleteExistingFile($invoice['senderAddress']['company_logo']);
                        //return $invoice['senderAddress']['company_logo'];
                    }
                }
                // if ($invoice->has("media")) {
                //     $media_id = $invoice['media']['id'];
                //     $attachment_id = $invoice['media']['pivot']['id'];
                //     $attachement = Attachment::where('media_id', $media_id)->get();

                //     if (count($attachement) > 0) {
                //         $getOneAttachment = Attachment::find($attachment_id);

                //         if ($getOneAttachment) {
                //             $this->invoiceService->deleteExistingFile($invoice['media']['short_link']);
                //             $getOneAttachment->delete();
                //         }
                //     } else {

                //         $this->invoiceService->deleteExistingFile($invoice['media']['short_link']);
                //         $invoice->media()->delete();
                //         DB::commit();
                //     }

                //     return $invoice['media'];
                // } else {
                //     return 'not found';
                // }
                $invoice->invoiceItems()->delete();
                $invoice->receiverAddress()->delete();
                $invoice->senderAddress()->delete();
                $invoice->delete();
                DB::commit();
                return $this->success(null, '', 200);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error('Data Not Found', 201);
        };
    }
}
