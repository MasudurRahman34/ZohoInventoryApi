<?php

namespace App\Http\Services\V1;


use App\Models\Payment;
use Exception;

class PaymentService
{


    public function store($request)
    {
        switch ($request['source']) {
            case "bill":
                $request['paymentable_type'] = Payment::$paymetableType['bill'];
                break;
            case "invoice":
                $request['paymentable_type'] = Payment::$paymetableType['invoice'];
                break;
            case "sale":
                $request['paymentable_type'] = Payment::$paymetableType['sale'];
                break;
            default:
                throw new Exception('invalid source');
        };
        $newPayment = Payment::create($request);
        return $newPayment;
    }

    public function update($item, $contact)
    {
    }
}
