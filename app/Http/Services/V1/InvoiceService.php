<?php

namespace App\Http\Services\V1;

use App\Models\Address;
use App\Models\Country;
use App\Models\GlobalAddress;
use App\Models\Invoice;
use App\Models\InvoiceAddress;
use App\Models\InvoiceItem;
use App\Models\InvoiceReceiverAddress;
use App\Models\InvoiceSenderAddress;
use App\Models\Location\District;
use App\Models\Location\State;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
use App\Notifications\V1\InvoiceNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Notification;;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class InvoiceService
{
    private $addressService;
    private array $fullAddress;
    private string $plainTextAddress;
    public $addressKeys = [  //serilized for geneatation plain text
        'house', 'street_address_line_2', 'street_address_line_1', 'union_name', 'zipcode', 'thana_name', 'district_name', 'state_name', 'country_name',
    ];
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }
    public function store($request)
    {
        $invoiceData = [
            'customer_id' => isset($request['customer_id']) ? $request['customer_id'] : NULL,
            'customer_name' => isset($request['customer_name']) ? $request['customer_name'] : NULL,
            'warehouse_id' => isset($request['warehouse_id']) ? $request['warehouse_id'] : NUll,
            'shipping_address' => isset($request['shipping_address']) ? $request['shipping_address'] : NULL,
            'billing_address' => isset($request['billing_address']) ? $request['billing_address'] : NULL,
            'order_number' => isset($request['order_number']) ? $request['order_number'] : NULL,
            'invoice_number' => isset($request['invoice_number']) ? $request['invoice_number'] : NULL,
            'short_code' => $this->generateShorCode('invoices', 'short_code', 6), //generate from system
            'order_id' => isset($request['order_id']) ? $request['order_id'] : NULL,
            'invoice_date' => isset($request['invoice_date']) ? $request['invoice_date'] : Carbon::now(),
            'due_date' => isset($request['due_date']) ? $request['due_date'] : NULL,

            'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,
            'order_tax_amount' => isset($request['order_tax_amount']) ? $request['order_tax_amount'] : 0,
            'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : 0,
            'discount_type' => isset($request['discount_type']) ? $request['discount_type'] : 0,
            'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
            'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
            'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
            'total_tax' => isset($request['total_amount']) ? $request['total_tax'] : 0,
            'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
            'balance' => isset($request['balance']) ? $request['balance'] : 0,
            'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
            'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
            // 'recieved_amount' => isset($request['recieved_amount']) ? $request['recieved_amount'] : 0,
            'changed_amount' => isset($request['changed_amount']) ? $request['changed_amount'] : 0,
            'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,

            'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
            'invoice_terms' => isset($request['invoice_terms']) ? $request['invoice_terms'] : NULL,
            'invoice_description' => isset($request['invoice_description']) ? $request['invoice_description'] : NULL,

            'invoice_type' => isset($request['invoice_type']) ? $request['invoice_type'] : NULL,
            'invoice_currency' => isset($request['invoice_currency']) ? $request['invoice_currency'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : 0,
            'user_ip' => isset($request['user_ip']) ? $request['user_ip'] : NULL,
        ];
        $newInvoice = Invoice::create($invoiceData); //store invoice

        //insert new invoice items
        if ($newInvoice) {
            if (isset($request['invoiceItems'])) {
                if (count($request['invoiceItems']) > 0) {
                    foreach ($request['invoiceItems'] as $items) {

                        $this->storeinvoiceItem($items, $newInvoice);
                    }
                }
            }
        }
        return $newInvoice;
    }

    public function storeinvoiceItem($item, $newInvoice) //store invoice item
    {
        $invoiceItem = [
            'invoice_id' => $newInvoice->id,
            'service_date' => isset($item['service_date']) ? $item['service_date'] : NULL,
            'product_id' => isset($item['product_id']) ? $item['product_id'] : NULL,
            'warehouse_id' => isset($item['warehouse_id']) ? $item['warehouse_id'] : NUll,
            'order_id' => isset($item['order_id']) ? $item['order_id'] : NULL,
            'product_name' => isset($item['product_name']) ? $item['product_name'] : NULL,
            'serial_number' => isset($item['serial_number']) ? $item['serial_number'] : NULL,
            'group_number' => isset($item['group_number']) ? $item['group_number'] : NULL,

            'product_description' => isset($item['product_description']) ? $item['product_description'] : NULL,
            'order_number' => isset($item['order_number']) ? $item['order_number'] : NULL,
            'product_qty' => isset($item['product_qty']) ? $item['product_qty'] : NULL,

            'unit_price' => isset($item['unit_price']) ? $item['unit_price'] : 0,
            'product_discount' => isset($item['product_discount']) ? $item['product_discount'] : 0,
            'tax_name' => isset($item['tax_name']) ? $item['tax_name'] : 0,
            'tax_rate' => isset($item['tax_rate']) ? $item['tax_rate'] : 0,
            'tax_amount' => isset($item['tax_amount']) ? $item['tax_amount'] : 0,
            'whole_price' => isset($item['whole_price']) ? $item['whole_price'] : 0,
            'subtotal' => isset($item['subtotal']) ? $item['subtotal'] : 0,
            'total_tax' => isset($item['total_amount']) ? $item['total_tax'] : 0,
            'is_taxable' => isset($item['is_taxable']) ? $item['is_taxable'] : 0,
            'is_serialized' => isset($item['is_serialized']) ? $item['is_serialized'] : 0,

        ];
        $newInvoiceItem = InvoiceItem::create($invoiceItem);
        return $newInvoice;
    }

    public function invoiceAddress($request, $reference, $newInvoice)
    {

        $addressData = [
            'invoice_id' => $newInvoice->id,
            'attention' => isset($request['attention']) ? $request['attention'] : null,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : null,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : null,
            'company_info' => isset($request['company_info']) ? $request['company_info'] : null,
            'client_info' => isset($request['client_info']) ? $request['client_info'] : null,
            'additional_info' => isset($request['additional_info']) ? $request['additional_info'] : null,
            'tax_number' => isset($request['tax_number']) ? $request['tax_number'] : null,

            'first_name' => isset($request['first_name']) ? $request['first_name'] : null,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : null,

            'mobile' => isset($request['mobile']) ? $request['mobile'] : null,
            'mobile_country_code' => isset($request['mobile_country_code']) ? $request['mobile_country_code'] : null,
            'email' => isset($request['email']) ? $request['email'] : null,
            'phone' => isset($request['phone']) ? $request['phone'] : null,
            'fax' => isset($request['fax']) ? $request['fax'] : null,
            'website' => isset($request['website']) ? $request['website'] : null,

            'country_id' => isset($request['country_id']) ? $request['country_id'] : 0,
            'country_name' => isset($request['country_name']) ? $request['country_name'] : NULL,
            'state_name' => isset($request['state_name']) ? $request['state_name'] : NULL,
            'district_name' => isset($request['district_name']) ? $request['district_name'] : NULL,
            'thana_name' => isset($request['thana_name']) ? $request['thana_name'] : NULL,
            'union_name' => isset($request['union_name']) ? $request['union_name'] : NULL,
            'zipcode' => isset($request['zipcode']) ? $request['zipcode'] : NULL,
            'street_address_line_1' => isset($request['street_address_line_1']) ? $request['street_address_line_1'] : NULL,
            'street_address_line_2' => isset($request['street_address_line_2']) ? $request['street_address_line_2'] : NULL,
            'house' => isset($request['house']) ? $request['house'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : 1,

        ];
        $this->setPlainTextAndFullAddress($addressData); //set full and plain address , serialized by addressKey
        $addressData['plain_address'] = $this->plainTextAddress;
        $addressData['full_address'] = $this->fullAddress;

        if ($reference == 'sender') { //insert new sender address
            $addressData['addressable_type'] = "sender";
            //image upload
            if (isset($request['company_logo'])) {
                if (file_exists($request['company_logo'])) {
                    $addressData['company_logo'] = $this->uploadCompanyLogo($request['company_logo']);
                }
            }
            $newSenderAddress = InvoiceAddress::create($addressData);
        }
        if ($reference == 'receiver') { //insert new reciever address
            $addressData['addressable_type'] = "receiver";
            $newRecieverAddress = InvoiceAddress::create($addressData);
        }

        if (!\is_null($addressData['email'])) { //sending email to reciever and sender
            Notification::route('mail', $addressData['email'])->notify(new InvoiceNotification($newInvoice));
        }

        return;
    }

    public function updateInvoiceAddress($request, $reference, $existAddress, $updatedInvoice)
    {

        $addressData = [
            'invoice_id' => $updatedInvoice->id,
            'attention' => isset($request['attention']) ? $request['attention'] : $existAddress->attention,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : $existAddress->display_name,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : $existAddress->company_name,
            'company_info' => isset($request['company_info']) ? $request['company_info'] : $existAddress->company_info,
            'client_info' => isset($request['client_info']) ? $request['client_info'] : $existAddress->client_info,
            'additional_info' => isset($request['additional_info']) ? $request['additional_info'] : $existAddress->additional_info,
            'tax_number' => isset($request['tax_number']) ? $request['tax_number'] : $existAddress->tax_number,

            'first_name' => isset($request['first_name']) ? $request['first_name'] : $existAddress->first_name,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : $existAddress->last_name,

            'mobile' => isset($request['mobile']) ? $request['mobile'] : $existAddress->mobile,
            'mobile_country_code' => isset($request['mobile_country_code']) ? $request['mobile_country_code'] : $existAddress->mobile_country_code,
            'email' => isset($request['email']) ? $request['email'] : $existAddress->email,
            'phone' => isset($request['phone']) ? $request['phone'] : $existAddress->phone,
            'fax' => isset($request['fax']) ? $request['fax'] : $existAddress->fax,
            'website' => isset($request['website']) ? $request['website'] : $existAddress->website,

            'country_id' => isset($request['country_id']) ? $request['country_id'] : $existAddress->country_id,
            'country_name' => isset($request['country_name']) ? $request['country_name'] : $existAddress->country_name,
            'state_name' => isset($request['state_name']) ? $request['state_name'] : $existAddress->state_name,
            'district_name' => isset($request['district_name']) ? $request['district_name'] : $existAddress->district_name,
            'thana_name' => isset($request['thana_name']) ? $request['thana_name'] : $existAddress->thana_name,
            'union_name' => isset($request['union_name']) ? $request['union_name'] : $existAddress->union_name,
            'zipcode' => isset($request['zipcode']) ? $request['zipcode'] : $existAddress->zipcode,
            'street_address_line_1' => isset($request['street_address_line_1']) ? $request['street_address_line_1'] : $existAddress->street_address_line_1,
            'street_address_line_2' => isset($request['street_address_line_2']) ? $request['street_address_line_2'] : $existAddress->street_address_line_2,
            'house' => isset($request['house']) ? $request['house'] : $existAddress->house,
            'status' => isset($request['status']) ? $request['status'] : $existAddress->status,

        ];
        $this->setPlainTextAndFullAddress($addressData); //set full and plain address , serialized by addressKey
        $addressData['plain_address'] = $this->plainTextAddress;
        $addressData['full_address'] = $this->fullAddress;

        if ($reference == 'sender') { //insert new sender address
            $addressData['addressable_type'] = "sender";
            //image upload
            if (isset($request['company_logo'])) {
                if (file_exists($request['company_logo'])) { //check file has in request
                    $this->deleteExistingFile($existAddress->company_logo); //delete existing logo
                    $addressData['company_logo'] = $this->uploadCompanyLogo($request['company_logo']);
                }
            }
            $updateSenderAddress = $existAddress->update($addressData);
        }
        if ($reference == 'receiver') { //insert new reciever address
            $addressData['addressable_type'] = "receiver";
            $updateReceiverAddress = $existAddress->update($addressData);
        }

        if (!\is_null($addressData['email'])) { //sending email to reciever and sender
            Notification::route('mail', $addressData['email'])->notify(new InvoiceNotification($updatedInvoice));
        }

        return;
    }

    public function uploadCompanyLogo($company_logo): string //upload image and return database link
    {
        $fileName = $company_logo->getClientOriginalName();
        $uploadTo = base_path('public/uploads/invoice/public/' . date("Ym"));
        $existLink = base_path('public/uploads/invoice/public/' . date("Ym")) . '/' . $fileName;
        if (!File::isDirectory($uploadTo)) {
            File::makeDirectory($uploadTo, 0775, true, true); //making direcotry
        }

        if (file_exists($existLink)) {
            $increment = 0;
            list($name, $ext) = explode('.', $existLink);
            while (file_exists($existLink)) {
                $increment++;
                // rename if exist like example1.jpg, example2.jpg"
                $existLink = $name . $increment . '.' . $ext;
                $fileName = $name . $increment . '.' . $ext;
            }

            $fileName = Str::afterLast($existLink, '/'); //get only filename after increament from the folder link

        }
        $link =  'uploads/invoice/public/' . date("Ym") . '/' . $fileName;
        //$company_logo->move($uploadTo, $fileName);
        $company_logo->move($uploadTo, $fileName);

        $imageLocation = env('APP_URL') . '/' . $link; //database link

        return $imageLocation;
    }

    public function generateShorCode($table, $coloumn, $length_of_string): string  //generate shortcode
    {
        //for random string
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string = substr(str_shuffle($str_result), 0, $length_of_string);
        // $generateStringkey = date("Ymd") . '-' . $string;
        $isExistString =  DB::table($table)->where($coloumn, $string)->first();

        if ($isExistString) {
            return $this->generateShorCode($table, $coloumn, $length_of_string); //recurisuve if found generate new one
        } else {
            return $string;
        }
    }

    public function setPlainTextAndFullAddress(array $addressData): void //set plain and full text serialized based on decalare array
    {
        $plainTextAddress = [];

        foreach ($this->addressKeys as  $key) {

            if (!\is_null($addressData[$key])) {

                // $plainTextAddress += ' ' . $addressData[$key];
                $this->fullAddress[$key] = $addressData[$key];
                \array_push($plainTextAddress, $addressData[$key]);
            }
        }
        $this->plainTextAddress = implode(",", $plainTextAddress);
    }

    public function update($request, $invoice)
    {
        $invoiceData = [
            'customer_id' => isset($request['customer_id']) ? $request['customer_id'] : $invoice->customer_id,
            'customer_name' => isset($request['customer_name']) ? $request['customer_name'] : $invoice->customer_name,
            'warehouse_id' => isset($request['warehouse_id']) ? $request['warehouse_id'] : $invoice->warehouse_id,
            'shipping_address' => isset($request['shipping_address']) ? $request['shipping_address'] : $invoice->shipping_address,
            'billing_address' => isset($request['billing_address']) ? $request['billing_address'] : $invoice->billing_address,
            'order_number' => isset($request['order_number']) ? $request['order_number'] : $invoice->order_number,
            'invoice_number' => isset($request['invoice_number']) ? $request['invoice_number'] : $invoice->invoice_number,
            'short_code' => $invoice['short_code'], //generate from system
            'order_id' => isset($request['order_id']) ? $request['order_id'] : $invoice->order_id,
            'invoice_date' => isset($request['invoice_date']) ? $request['invoice_date'] : $invoice->invoice_date,
            'due_date' => isset($request['due_date']) ? $request['due_date'] : $invoice->due_date,

            'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : $invoice->order_tax,
            'order_tax_amount' => isset($request['order_tax_amount']) ? $request['order_tax_amount'] : $invoice->order_tax_amount,
            'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : $invoice->order_discount,
            'discount_type' => isset($request['discount_type']) ? $request['discount_type'] : $invoice->discount_type,
            'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : $invoice->shipping_charge,
            'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : $invoice->order_adjustment,
            'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : $invoice->total_amount,
            'total_tax' => isset($request['total_amount']) ? $request['total_tax'] : $invoice->total_tax,
            'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : $invoice->grand_total_amount,
            'balance' => isset($request['balance']) ? $request['balance'] : $invoice->balance,
            'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : $invoice->due_amount,
            'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : $invoice->paid_amount,
            // 'recieved_amount' => isset($request['recieved_amount']) ? $request['recieved_amount'] : $invoice->,
            'changed_amount' => isset($request['changed_amount']) ? $request['changed_amount'] : $invoice->changed_amount,
            'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : $invoice->last_paid_amount,

            'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : $invoice->adjustment_text,
            'invoice_terms' => isset($request['invoice_terms']) ? $request['invoice_terms'] : $invoice->invoice_terms,
            'invoice_description' => isset($request['invoice_description']) ? $request['invoice_description'] : $invoice->invoice_description,

            'invoice_type' => isset($request['invoice_type']) ? $request['invoice_type'] : $invoice->invoice_type,
            'invoice_currency' => isset($request['invoice_currency']) ? $request['invoice_currency'] : $invoice->invoice_currency,
            'status' => isset($request['status']) ? $request['status'] : $invoice->status,
            'user_ip' => isset($request['user_ip']) ? $request['user_ip'] : $invoice->user_ip,
        ];
        $updateInvoice = $invoice->update($invoiceData); //store invoice
        $invoice->invoiceItems()->delete();
        if ($updateInvoice) {
            $invoice->invoiceItems()->delete();
            if (isset($request['invoiceItems'])) {
                if (count($request['invoiceItems']) > 0) {
                    foreach ($request['invoiceItems'] as $item) {
                        $item['id'] = isset($item['id']) ? $item['id'] : 0;
                        $existItem = InvoiceItem::withTrashed()->where('id', $item['id'])->first();
                        if ($existItem) {
                            $this->updateInvoiceItem($item, $existItem);
                        }
                        if (!$existItem) {
                            $this->storeinvoiceItem($item, $invoice);
                        }
                    }
                }
            }
        }
        return $invoice;
    }

    public function updateInvoiceItem($item, $existItem)
    {
        $invoiceItem = [

            'service_date' => isset($item['service_date']) ? $item['service_date'] : $existItem->service_date,
            'product_id' => isset($item['product_id']) ? $item['product_id'] : $existItem->product_id,
            'warehouse_id' => isset($item['warehouse_id']) ? $item['warehouse_id'] : $existItem->warehouse_id,
            'order_id' => isset($item['order_id']) ? $item['order_id'] : $existItem->order_id,
            'product_name' => isset($item['product_name']) ? $item['product_name'] : $existItem->product_name,
            'serial_number' => isset($item['serial_number']) ? $item['serial_number'] : $existItem->serial_number,
            'group_number' => isset($item['group_number']) ? $item['group_number'] : $existItem->group_number,

            'product_description' => isset($item['product_description']) ? $item['product_description'] : $existItem->product_description,
            'order_number' => isset($item['order_number']) ? $item['order_number'] : $existItem->order_number,
            'product_qty' => isset($item['product_qty']) ? $item['product_qty'] : $existItem->product_qty,

            'unit_price' => isset($item['unit_price']) ? $item['unit_price'] : $existItem->unit_price,
            'product_discount' => isset($item['product_discount']) ? $item['product_discount'] : $existItem->product_discount,
            'tax_name' => isset($item['tax_name']) ? $item['tax_name'] : $existItem->tax_name,
            'tax_rate' => isset($item['tax_rate']) ? $item['tax_rate'] : $existItem->tax_rate,
            'tax_amount' => isset($item['tax_amount']) ? $item['tax_amount'] : $existItem->tax_amount,
            'whole_price' => isset($item['whole_price']) ? $item['whole_price'] : $existItem->whole_price,
            'subtotal' => isset($item['subtotal']) ? $item['subtotal'] : $existItem->subtotal,
            'total_tax' => isset($item['total_amount']) ? $item['total_tax'] : $existItem->total_tax,
            'is_taxable' => isset($item['is_taxable']) ? $item['is_taxable'] : $existItem->is_taxable,
            'is_serialized' => isset($item['is_serialized']) ? $item['is_serialized'] : $existItem->is_serialized,
            'deleted_at' => NULL,
            'updated_at' => Carbon::now(),

        ];
        $updateInvoiceItem = $existItem->update($invoiceItem);
        return $updateInvoiceItem;
    }

    public function deleteExistingFile($fileLink)
    {
        $pdf_link = implode(explode(\env('APP_URL'), $fileLink));
        $pdf_link = \base_path('public' . $pdf_link);
        if (File::exists($pdf_link)) {
            File::delete($pdf_link);
        }
    }
}
