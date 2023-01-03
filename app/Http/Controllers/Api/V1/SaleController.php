<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\SaleRequest;
use App\Http\Resources\v1\Collections\SaleCollection;
use App\Http\Resources\v1\SaleResource;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    use ApiFilter, ApiResponse;
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Sale::where('account_id', $this->account_id)->with('customer')->with('saleItems');
        $this->dateRangeQuery($request, $query, 'sales_order_date');
        $sales = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new SaleCollection($sales));
    }

    public function show($id)
    {
        $sale = Sale::with('customer')->with('saleItems')->where('account_id', Auth::user()->account_id)->find($id);
        if ($sale) {
            return $this->success(new SaleResource($sale));
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
    public function store(SaleRequest $request)
    {

        //return $request
        DB::beginTransaction();
        try {
            $saleData = [
                'customer_id' => $request['customer_id'],
                'warehouse_id' => $request['warehouse_id'],
                'order_number' => isset($request['order_number']) ? $request['order_number'] : NULL,
                'sales_order_date' => isset($request['sales_order_date']) ? $request['sales_order_date'] : NULL,
                'expected_shipment_date' => isset($request['expected_shipment_date']) ? $request['expected_shipment_date'] : NULL,
                'billing_address' => isset($request['billing_address']) ? $request['billing_address'] : NULL,
                'shipping_address' => isset($request['shipping_address']) ? $request['shipping_address'] : NULL,
                'delivery_method' => isset($request['delivery_method']) ? $request['delivery_method'] : NULL,
                'reference' => isset($request['reference']) ? $request['reference'] : NULL,
                'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : 0,
                'discount_currency' => isset($request['discount_currency']) ? $request['discount_currency'] : 0,
                'order_discount_amount' => isset($request['order_discount_amount']) ? $request['order_discount_amount'] : 0,
                'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,
                'order_tax_amount' => isset($request['order_tax_amount']) ? $request['order_tax_amount'] : 0,
                'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
                'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
                'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
                'customer_note' => isset($request['customer_note']) ? $request['customer_note'] : NULL,
                'terms_condition' => isset($request['terms_condition']) ? $request['terms_condition'] : NULL,

                'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
                'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
                'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
                'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
                'recieved_amount' => isset($request['recieved_amount']) ? $request['recieved_amount'] : 0,
                'changed_amount' => isset($request['changed_amount']) ? $request['changed_amount'] : 0,                
                'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,
                'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] : NULL,
                'image' => isset($request['image']) ? $request['image'] : NULL,
                'offer_to' => isset($request['offer_to']) ? $request['offer_to'] : NULL,
                'offer_subject' => isset($request['offer_subject']) ? $request['offer_subject'] : NULL,
                'offer_greetings' => isset($request['offer_greetings']) ? $request['offer_greetings'] : NULL,
                'offer_terms_condition' => isset($request['offer_terms_condition']) ? $request['offer_terms_condition'] : NULL,   
                'invoice_status' => isset($request['invoice_status']) ? $request['invoice_status'] : '0',
                'shipment_status' => isset($request['shipment_status']) ? $request['shipment_status'] : '0',
                'status' => isset($request['status']) ? $request['status'] : '0',
                'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',
                'sales_type' => isset($request['sales_type']) ? $request['sales_type'] : '0',
                'salesperson' => Auth::user()->id,

            ];
            $sale = Sale::create($saleData);
            if ($sale) {
                if ($request->has('line_id')) {
                    $saleItems = array();
                    $saleItems['line_id'] = $request['line_id'];
                    $saleItems['deleted_line_id'] = $request['deleted_line_id'];
                    //$saleItems['deleted_inventory_line_id'] = $request['deleted_inventory_line_id'];
                    $saleItems['product_id'] = $request['product_id'];
                    $saleItems['description'] = $request['description'];
                    $saleItems['serial_number'] = $request['serial_number'];
                    // Generate sale price according to settings
                  
                    $saleItems['product_qty'] = $request['product_qty'];
                    $saleItems['packed_qty'] = $request['packed_qty'];
                    $saleItems['shipped_qty'] = $request['shipped_qty'];
                    $saleItems['invoice_qty'] = $request['invoice_qty'];
                    $saleItems['unit_price'] = $request['unit_price'];
                    $saleItems['product_discount'] = $request['product_discount'];
                    $saleItems['product_tax'] = $request['product_tax'];
                    $saleItems['subtotal'] = $request['subtotal'];
                }


                $saleItem = new SaleItem();
                $saleItem->store($saleItems, $request['warehouse_id'], $sale->id);
            }
            DB::commit();
            $sale = Sale::with('saleItems')->where('account_id', Auth::user()->account_id)->find($sale->id);
            return $this->success(new SaleResource($sale),201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
        }
    }
    public function update(SaleRequest $sale, $id)
    {
    }

    //soft delete customer
    public function delete($id)
    {
        $sale = Sale::where('account_id', Auth::user()->account_id)->find($id);
        if ($sale) {
            $sale->destroy($id);
            return $this->success(null, 200);
        } else {
            return $this->error('Data Not Found', 201);
        };
    }
}
