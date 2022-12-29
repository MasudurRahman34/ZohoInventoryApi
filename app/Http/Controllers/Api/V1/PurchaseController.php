<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\PurchaseRequest;
use App\Http\Resources\v1\Collections\PurchaseCollection;
use App\Http\Resources\v1\PurchaseResource;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class PurchaseController extends Controller
{
    use ApiFilter, ApiResponse;
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Purchase::where('account_id', $this->account_id)->with('supplier')->with('purchaseItems');
        $this->dateRangeQuery($request, $query, 'purchase_date');
        $purchases = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new PurchaseCollection($purchases));
    }

    public function show($id)
    {
        $purchase = Purchase::with('supplier')->with('purchaseItems')->where('account_id', Auth::user()->account_id)->find($id);
        if ($purchase) {
            return $this->success(new PurchaseResource($purchase));
        } else {
            return $this->error('Data Not Found', 404);
        }
    }
    public function store(PurchaseRequest $request)
    {

        //return $request
        DB::beginTransaction();
        try {
            $purchaseData = [
                'supplier_id' => $request['supplier_id'],
                'warehouse_id' => $request['warehouse_id'],
                'invoice_no' => isset($request['invoice_no']) ? $request['invoice_no'] : NULL,
                'reference' => isset($request['reference']) ? $request['reference'] : NULL,
                'total_amount' => isset($request['total_amount']) ? $request['total_amount'] : 0,
                'due_amount' => isset($request['due_amount']) ? $request['due_amount'] : 0,
                'paid_amount' => isset($request['paid_amount']) ? $request['paid_amount'] : 0,
                'grand_total_amount' => isset($request['grand_total_amount']) ? $request['grand_total_amount'] : 0,
                'order_discount' => isset($request['order_discount']) ? $request['order_discount'] : 0,
                'discount_currency' => isset($request['discount_currency']) ? $request['discount_currency'] : 0,
                'order_tax' => isset($request['order_tax']) ? $request['order_tax'] : 0,
                'shipping_charge' => isset($request['shipping_charge']) ? $request['shipping_charge'] : 0,
                'order_adjustment' => isset($request['order_adjustment']) ? $request['order_adjustment'] : 0,
                'last_paid_amount' => isset($request['last_paid_amount']) ? $request['last_paid_amount'] : 0,
                'adjustment_text' => isset($request['adjustment_text']) ? $request['adjustment_text'] : NULL,
                'purchase_date' => isset($request['purchase_date']) ? $request['purchase_date'] : NULL,
                'delivery_date' => isset($request['delivery_date']) ? $request['delivery_date'] : 0,
                'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] : 0,
                'image' => isset($request['image']) ? $request['image'] : 0,
                'status' => isset($request['status']) ? $request['status'] : '0',
                'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

            ];
            $purchase = Purchase::create($purchaseData);
            if ($purchase) {
                if ($request->has('line_id')) {
                    $purchaseItems = array();
                    $purchaseItems['line_id'] = $request['line_id'];
                    $purchaseItems['deleted_line_id'] = $request['deleted_line_id'];
                    //$purchaseItems['deleted_inventory_line_id'] = $request['deleted_inventory_line_id'];
                    $purchaseItems['product_id'] = $request['product_id'];
                    $purchaseItems['description'] = $request['description'];
                    $purchaseItems['serial_number'] = $request['serial_number'];
                    // Generate purchase price according to settings
                    $purchaseItems['unit_price'] = $request['product_qty'];
                    $purchaseItems['product_qty'] = $request['product_qty'];
                    $purchaseItems['received_qty'] = $request['received_qty'];
                    $purchaseItems['product_discount'] = $request['product_discount'];
                    $purchaseItems['product_tax'] = $request['product_tax'];
                    $purchaseItems['subtotal'] = $request['subtotal'];
                }


                $purchaseItem = new PurchaseItem();
                $purchaseItem->store($purchaseItems, $request['warehouse_id'], $purchase->id);
            }
            DB::commit();
            $purchase = Purchase::with('purchaseItems')->where('account_id', Auth::user()->account_id)->find($purchase->id);
            return $this->success(new PurchaseResource($purchase),201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 200);
        }
    }
    public function update(PurchaseRequest $purchase, $id)
    {
    }

    //soft delete supplier
    public function delete($id)
    {
        $purchase = Purchase::where('account_id', Auth::user()->account_id)->find($id);
        if ($purchase) {
            $purchase->destroy($id);
            return $this->success(null, 200);
        } else {
            return $this->error('Data Not Found', 201);
        };
    }
}
