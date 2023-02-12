<?php

namespace App\Http\Services\V1;

use App\Models\Address;
use App\Models\Country;
use App\Models\GlobalAddress;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceReceiverAddress;
use App\Models\InvoiceSenderAddress;
use App\Models\Location\District;
use App\Models\Location\State;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class InvoiceService
{
    private $addressService;
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
        ];
        $newInvoice = Invoice::create($invoiceData);

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

    public function storeinvoiceItem($item, $newInvoice)
    {
        $invoiceItem = [
            'invoice_id' => $newInvoice->id,
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
            'invoice_id' => $newInvoice,
            'attention' => isset($request['attention']) ? $request['attention'] : null,
            'display_name' => isset($request['display_name']) ? $request['display_name'] : null,
            'company_name' => isset($request['company_name']) ? $request['company_name'] : null,
            'company_info' => isset($request['company_info']) ? $request['company_info'] : null,

            'first_name' => isset($request['first_name']) ? $request['first_name'] : null,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : null,

            'mobile' => isset($request['mobile']) ? $request['mobile'] : null,
            'mobile_country_code' => isset($request['mobile_country_code']) ? $request['mobile_country_code'] : null,
            'email' => isset($request['email']) ? $request['email'] : null,
            'phone' => isset($request['phone']) ? $request['phone'] : null,
            'fax' => isset($request['fax']) ? $request['fax'] : null,
            'country_id' => isset($request['country_id']) ? $request['country_id'] : 0,
            'state_id' => isset($request['state_id']) ? $request['state_id'] : 0,
            'district_id' => isset($request['district_id']) ? $request['district_id'] : 0,
            'thana_id' => isset($request['thana_id']) ? $request['thana_id'] : 0,
            'union_id' => isset($request['union_id']) ? $request['union_id'] : 0,
            'zipcode_id' => isset($request['zipcode_id']) ? $request['zipcode_id'] : 0,
            'street_address_id' => isset($request['street_address_id']) ? $request['street_address_id'] : 0,
            'house' => isset($request['house']) ? $request['house'] : 0,
            'status' => isset($request['status']) ? $request['status'] : 1,
            'full_address' => $this->addressService->setAddress($request),

        ];
        // if($reference=="sender"){
        // }

        $addressData['plain_address'] = $this->addressService->setPlainAddress($addressData['full_address']);
        if ($reference == 'sender') {
            if (isset($request['company_logo'])) {
                if (file_exists($request['company_logo'])) {

                    $company_logo = $request['company_logo'];
                    $fileName = $company_logo->getClientOriginalName();
                    $uploadTo = base_path('public/uploads/invoice/public/' . date("Ym"));
                    $existLink = base_path('public/uploads/invoice/public/' . date("Ym")) . '/' . $fileName;

                    if (file_exists($existLink)) {
                        $increment = 0;
                        list($name, $ext) = explode('.', $existLink);
                        while (file_exists($existLink)) {
                            $increment++;
                            // rename if exsist like example1.jpg, example2.jpg"
                            $existLink = $name . $increment . '.' . $ext;
                            $fileName = $name . $increment . '.' . $ext;
                        }

                        $fileName = Str::afterLast($existLink, '/'); //get only filename after increament from the folder link

                    }
                    $link =  'uploads/invoice/public/' . date("Ym") . '/' . $fileName;
                    $company_logo->move($uploadTo, $fileName);

                    $addressData['company_logo'] = env('APP_URL') . '/' . $link;
                }
            }
            $newSenderAddress = InvoiceSenderAddress::create($addressData);
        }
        if ($reference == 'reciever') {
            $newRecieverAddress = InvoiceReceiverAddress::create($addressData);
        }

        return;
    }

    public function renameFileIfExsist()
    {
    }
    public function delete()
    {
    }

    public function setAddress($request)
    {
        //$add=Country::where('id',$request['country_id'])->select('id','countryName')->get();
        //return print_r($add);

        $address['country'] = Country::where('id', $request['country_id'])->select('id', 'country_name')->first();
        $address['state_id'] = State::where('id', $request['state_id'])->select('id', 'state_name')->first();
        $address['district'] = District::where('id', $request['district_id'])->select('id', 'district_name')->first();
        $address['thana'] = Thana::where('id', $request['thana_id'])->select('id', 'thana_name')->first();
        $address['union'] = Union::where('id', $request['union_id'])->select('id', 'union_name')->first();
        $address['zipcode'] = Zipcode::where('id', $request['zipcode_id'])->select('id', 'zip_code')->first();
        $address['street_address'] = StreetAddress::where('id', $request['street_address_id'])->select('id', 'street_address_value')->first();
        //dd($address);
        return $address;
    }

    public function setPlainAddress($fullAddress)
    {
        $plainAddress = $fullAddress['street_address']['street_address_value'] . '-' . $fullAddress['zipcode']['zip_code'] . ', ' . $fullAddress['union']['union_name'] . ', ' . $fullAddress['thana']['thana_name'] . ', ' . $fullAddress['district']['district_name'] . ', ' . $fullAddress['country']['country_name'];
        return  $plainAddress;
    }

    public function storeGlobalAddress($address)
    {
        $is_find_global_address = GlobalAddress::where('full_address', json_encode($address->full_address))->first();
        if (!$is_find_global_address) {
            $globalAddress = new GlobalAddress();
            $globalAddress->country_id = $address->country_id;
            $globalAddress->state_id = $address->state_id;
            $globalAddress->district_id = $address->district_id;
            $globalAddress->thana_id = $address->thana_id;
            $globalAddress->union_id = $address->union_id;
            $globalAddress->zipcode_id = $address->zipcode_id;
            $globalAddress->street_address_id = $address->street_address_id;
            $globalAddress->full_address = $address->full_address;
            $globalAddress->plain_address = $this->setPlainAddress($address->full_address);
            $globalAddress->status = 1;
            $globalAddress->save();
            return $globalAddress;
        } else {
            return $address;
        }
    }

    public function generateShorCode($table, $coloumn, $length_of_string)
    {
        //for random string
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string = substr(str_shuffle($str_result), 0, $length_of_string);
        // $generateStringkey = date("Ymd") . '-' . $string;
        $isExistString =  DB::table($table)->where($coloumn, $string)->first();

        if ($isExistString) {
            return $this->generateShorCode($table, $coloumn, $length_of_string);
        } else {
            return $string;
        }
    }
}
