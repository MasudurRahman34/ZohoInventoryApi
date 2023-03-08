<?php

namespace App\Http\Services\V1;

use App\Models\Purchase;
use Illuminate\Http\Request;

class CalculateProductPriceService
{

    private $tax_amount = 0;
    private $product_discount = 0;
    private $whole_price = 0;
    private $subtotal = 0;
    private $total_amount = 0;
    private $total_whole_amount = 0;
    private $paid_amount = 0;
    private $balance = 0;
    private $grand_total_amount = 0;
    private $shipping_charge = 0;
    private $order_adjustment = 0;  //numeric
    private $discount_percentage = 0;   //percentage
    private $discount_amount = 0;   //numeric
    private $order_discount = 0;   //numeric
    private $total_product_discount = 0; //sum of product discount numeric arthmetic
    // private $discount_currency = 0;
    // private $order_tax = 0;
    private $total_tax = 0;


    //puchase section
    public function purchasePrice($request)
    {


        // $request['total_amount'] = 0;
        // $request['grand_total_amount'] = 0;
        // $request['shipping_charge'] = isset($request['shipping_charge']) ? $request['shipping_charge'] : 0;
        // $request['order_adjustment'] = isset($request['order_adjustment']) ? $request['order_adjustment'] : 0;
        // $request['order_discount'] = isset($request['order_discount']) ? $request['order_discount'] : 0;
        // $request['discount_currency'] = isset($request['discount_currency']) ? $request['discount_currency'] : 0;
        // $request['order_tax'] = isset($request['order_tax']) ? $request['order_tax'] : 0;
        // $request['tax_rate'] = isset($request['tax_rate']) ? $request['tax_rate'] : null;

        if (count($request['purchaseItems']) > 0) {
            foreach ($request['purchaseItems'] as $key => $item) {

                //initializing and overriding purchase item
                // $request['purchaseItems'][$key]['subtotal'] = 0;
                $request['purchaseItems'][$key]['unit_price'] = $item['unit_price'] = isset($item['unit_price']) ? $item['unit_price'] : 0;
                $request['purchaseItems'][$key]['product_qty'] = $item['product_qty'] = isset($item['product_qty']) ? $item['product_qty'] : 0;
                $request['purchaseItems'][$key]['product_discount'] = $item['product_discount'] = isset($item['product_discount']) ? $item['product_discount'] : 0;
                $request['purchaseItems'][$key]['is_taxable'] = $item['is_taxable'] = isset($item['is_taxable']) ? $item['is_taxable'] : 0;
                // $request['purchaseItems'][$key]['product_tax'] = $item['product_tax'] = isset($item['product_tax']) ? $item['product_tax'] : 0;
                $request['purchaseItems'][$key]['tax_rate'] = $item['tax_rate'] = isset($item['tax_rate']) ? $item['tax_rate'] : 0;

                // $request['purchaseItems'][$key]['subtotal'] = $this->calculateSubtotal($item); //calculating subtotal
                $this->calculateItem($item);
                $request['purchaseItems'][$key]['subtotal'] = $this->subtotal;
                $request['purchaseItems'][$key]['tax_amount'] = $this->tax_amount;
                $request['purchaseItems'][$key]['whole_price'] = $this->whole_price;
                $request['purchaseItems'][$key]['product_discount'] = $this->product_discount;

                // $request['total_amount'] += $this->subtotal;
                $this->total_amount += $this->subtotal;
                $this->total_tax += $this->tax_amount;
                $this->total_whole_amount += $this->whole_price;
                $this->total_product_discount += $this->product_discount;
            }
            $this->shipping_charge = $request['shipping_charge'] =  isset($request['shipping_charge']) ? $request['shipping_charge'] : 0;
            $this->order_adjustment = $request['order_adjustment'] =  isset($request['order_adjustment']) ? $request['order_adjustment'] : 0;
            $this->discount_percentage = $request['discount_percentage'] = isset($request['discount_percentage']) ? $request['discount_percentage'] : 0; //percentage
            // $this->discount_amount = $request['discount_amount'] = isset($request['discount_amount']) ? $request['discount_amount'] : 0;
            $this->paid_amount = $request['paid_amount'] =  isset($request['paid_amount']) ? $request['paid_amount'] : 0;
        }

        // $request['grand_total_amount'] = $this->calculateGrandTotal($request); //calculate and overiding subtotal
        $this->calculateTotal(); //calculate and overiding grandttoal
        $request['total_amount'] = $this->total_amount;
        $request['grand_total_amount'] = $this->grand_total_amount;
        $request['total_tax'] = $this->total_tax;
        $request['balance'] = $this->balance;
        $request['total_whole_amount'] = $this->total_whole_amount;
        $request['total_product_discount'] = $this->total_product_discount;
        $request['discount_amount'] = $this->discount_amount;

        return $request;
    }


    //end purchase section
    //invoice
    public function invoicePrice($request)
    {


        if (count($request['invoiceItems']) > 0) {
            foreach ($request['invoiceItems'] as $key => $item) {

                //initializing and overriding purchase item
                $request['invoiceItems'][$key]['unit_price'] = $item['unit_price'] = isset($item['unit_price']) ? $item['unit_price'] : 0;
                $request['invoiceItems'][$key]['product_qty'] = $item['product_qty'] = isset($item['product_qty']) ? $item['product_qty'] : 0;
                $request['invoiceItems'][$key]['product_discount'] = $item['product_discount'] = isset($item['product_discount']) ? $item['product_discount'] : 0;
                $request['invoiceItems'][$key]['is_taxable'] = $item['is_taxable'] = isset($item['is_taxable']) ? $item['is_taxable'] : 0;

                $request['invoiceItems'][$key]['tax_rate'] = $item['tax_rate'] = isset($item['tax_rate']) ? $item['tax_rate'] : 0;

                $this->calculateItem($item);
                $request['invoiceItems'][$key]['subtotal'] = $this->subtotal;
                $request['invoiceItems'][$key]['tax_amount'] = $this->tax_amount;
                $request['invoiceItems'][$key]['whole_price'] = $this->whole_price;
                $request['invoiceItems'][$key]['product_discount'] = $this->product_discount;

                // $request['total_amount'] += $this->subtotal;
                $this->total_amount += $this->subtotal;
                $this->total_tax += $this->tax_amount;
                $this->total_whole_amount += $this->whole_price;
                $this->total_product_discount += $this->product_discount;
            }
            //initializing and overriding invoice Item
            $this->shipping_charge = $request['shipping_charge'] =  isset($request['shipping_charge']) ? $request['shipping_charge'] : 0;
            $this->order_adjustment = $request['order_adjustment'] =  isset($request['order_adjustment']) ? $request['order_adjustment'] : 0;
            $this->discount_percentage = $request['discount_percentage'] = isset($request['discount_percentage']) ? $request['discount_percentage'] : 0; //percentage
            // $this->discount_amount = $request['discount_amount'] = isset($request['discount_amount']) ? $request['discount_amount'] : 0;
            $this->paid_amount = $request['paid_amount'] =  isset($request['paid_amount']) ? $request['paid_amount'] : 0;
            // $this->order_tax = $request['order_tax'] =  isset($request['order_tax']) ? $request['order_tax'] : 0;
            // $this->total_tax = $request['tax_rate'] =  isset($request['tax_rate']) ? $request['tax_rate'] : null;
        }

        $this->calculateTotal(); //calculate and overiding grandttoal
        $request['total_amount'] = $this->total_amount;
        $request['grand_total_amount'] = $this->grand_total_amount;
        $request['total_tax'] = $this->total_tax;
        $request['balance'] = $this->balance;
        $request['total_whole_amount'] = $this->total_whole_amount;
        $request['total_product_discount'] = $this->total_product_discount;
        $request['discount_amount'] = $this->discount_amount;

        return $request;
    }


    public function billPrice($request)
    {


        if (count($request['billItems']) > 0) {
            foreach ($request['billItems'] as $key => $item) {

                //initializing and overriding purchase item
                $request['billItems'][$key]['unit_price'] = $item['unit_price'] = isset($item['unit_price']) ? $item['unit_price'] : 0;
                $request['billItems'][$key]['product_qty'] = $item['product_qty'] = isset($item['product_qty']) ? $item['product_qty'] : 0;
                $request['billItems'][$key]['product_discount'] = $item['product_discount'] = isset($item['product_discount']) ? $item['product_discount'] : 0;
                $request['billItems'][$key]['is_taxable'] = $item['is_taxable'] = isset($item['is_taxable']) ? $item['is_taxable'] : 0;

                $request['billItems'][$key]['tax_rate'] = $item['tax_rate'] = isset($item['tax_rate']) ? $item['tax_rate'] : 0;

                $this->calculateItem($item);
                $request['billItems'][$key]['subtotal'] = $this->subtotal;
                $request['billItems'][$key]['tax_amount'] = $this->tax_amount;
                $request['billItems'][$key]['whole_price'] = $this->whole_price;
                $request['billItems'][$key]['product_discount'] = $this->product_discount;

                // $request['total_amount'] += $this->subtotal;
                $this->total_amount += $this->subtotal;
                $this->total_tax += $this->tax_amount;
                $this->total_whole_amount += $this->whole_price;
                $this->total_product_discount += $this->product_discount;
            }
            //initializing and overriding invoice Item
            $this->shipping_charge = $request['shipping_charge'] =  isset($request['shipping_charge']) ? $request['shipping_charge'] : 0;
            $this->order_adjustment = $request['order_adjustment'] =  isset($request['order_adjustment']) ? $request['order_adjustment'] : 0;
            $this->order_discount = $request['order_discount'] = isset($request['order_discount']) ? $request['order_discount'] : 0;
            $this->discount_amount = $request['discount_amount'] = isset($request['discount_amount']) ? $request['discount_amount'] : 0;
            $this->paid_amount = $request['paid_amount'] =  isset($request['paid_amount']) ? $request['paid_amount'] : 0;
            // $this->order_tax = $request['order_tax'] =  isset($request['order_tax']) ? $request['order_tax'] : 0;
            // $this->total_tax = $request['tax_rate'] =  isset($request['tax_rate']) ? $request['tax_rate'] : null;
        }

        $this->calculateTotal(); //calculate and overiding grandttoal
        $request['total_amount'] = $this->total_amount;
        $request['grand_total_amount'] = $this->grand_total_amount;
        $request['total_tax'] = $this->total_tax;
        $request['balance'] = $this->balance;
        $request['total_whole_amount'] = $this->total_whole_amount;
        $request['total_product_discount'] = $this->total_product_discount;

        return $request;
    }



    public function calculateItem($item): void
    {
        $subtotal = $whole_price = ($item['unit_price'] * $item['product_qty']);

        if ($item['is_taxable'] == 1 && $item['tax_rate'] > 0) {
            $tax_amount = $whole_price * ($item['tax_rate'] / 100);
            $subtotal = $whole_price + $tax_amount; //tax applies each product
            // $this->tax_amount = $tax_amount;
        }
        $subtotal = $subtotal - $item['product_discount'];

        //return $subtotal;
        $this->subtotal = $subtotal;
        $this->whole_price = $whole_price;
        $this->product_discount = $item['product_discount'];
        $this->tax_amount = isset($tax_amount) ? $tax_amount : 0;
    }
    public function calculateTotal(): void
    {
        $this->discount_amount = $this->total_amount * ($this->discount_percentage / 100);
        $grand_total_amount = ($this->total_amount + $this->shipping_charge + $this->order_adjustment) - ($this->total_amount * ($this->discount_percentage / 100));
        // $grand_total_amount = $this->total_amount;
        $this->grand_total_amount = $grand_total_amount;
        $this->balance = $this->grand_total_amount - $this->paid_amount;
    }


    public function calculateGrandTotal($request): float
    {
        $grand_total_amount = ($request['total_amount'] + $request['shipping_charge'] + $request['order_adjustment']) - ($request['total_amount'] * ($request['order_discount'] / 100));
        return $grand_total_amount;
    }

    public function calculateSubtotal($item): float
    {
        $subtotal = ($item['unit_price'] * $item['product_qty']);
        if ($item['is_taxable'] == 1) {
            $subtotal = $subtotal + ($subtotal * ($item['product_tax'] / 100)); //tax applier each product
        }
        $subtotal = $subtotal - $item['product_discount'];
        return $subtotal;
    }
}
