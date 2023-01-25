<?php

namespace App\Http\Services\V1;

use App\Models\Purchase;
use Illuminate\Http\Request;

class CalculateProductPriceService
{


    public function purchasePrice($request)
    {

     
        $request['total_amount'] = 0;
        $request['grand_total_amount'] = 0;
        $request['shipping_charge'] = isset($request['shipping_charge']) ? $request['shipping_charge'] : 0;
        $request['order_adjustment'] = isset($request['order_adjustment']) ? $request['order_adjustment'] : 0;
        $request['order_discount'] = isset($request['order_discount']) ? $request['order_discount'] : 0;
        $request['discount_currency'] = isset($request['discount_currency']) ? $request['discount_currency'] : 0;
        $request['order_tax'] = isset($request['order_tax']) ? $request['order_tax'] : 0;
        $request['tax_rate'] = isset($request['tax_rate']) ? $request['tax_rate'] : null;
      
        if (count($request['purchaseItems']) > 0) {
            foreach ($request['purchaseItems'] as $key => $item) {
              
                //initializing and overriding purchase item
                $request['purchaseItems'][$key]['subtotal'] = 0;
                $request['purchaseItems'][$key]['unit_price'] = $item['unit_price'] = isset($item['unit_price']) ? $item['unit_price'] : 0;
                $request['purchaseItems'][$key]['product_qty'] = $item['product_qty'] = isset($item['product_qty']) ? $item['product_qty'] : 0;
                $request['purchaseItems'][$key]['product_discount'] = $item['product_discount'] = isset($item['product_discount']) ? $item['product_discount'] : 0;
                $request['purchaseItems'][$key]['is_taxable'] = $item['is_taxable'] = isset($item['is_taxable']) ? $item['is_taxable'] : 0;
                $request['purchaseItems'][$key]['product_tax'] = $item['product_tax'] = isset($item['product_tax']) ? $item['product_tax'] : 0;

                $request['purchaseItems'][$key]['subtotal'] = $this->calculateSubtotal($item); //calculating subtotal
                $request['total_amount'] += $request['purchaseItems'][$key]['subtotal'];
            }
        }

        $request['grand_total_amount'] = $this->calculateGrandTotal($request); //calculate and overiding subtotal
        return $request;
    }

    public function update($request, $purchase)
    {
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
        $subtotal=$subtotal-$item['product_discount'];
        return $subtotal;
    }
}
