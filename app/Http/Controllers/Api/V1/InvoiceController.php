<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\publicInvoiceRequest;
use App\Http\Services\V1\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use ApiResponse;
    private $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    public function public(publicInvoiceRequest $request)
    {
        return $request;
    }

    public function show($shortCode)
    {
    }
}
