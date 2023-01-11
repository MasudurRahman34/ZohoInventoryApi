<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\PurchaseRequest;
use App\Http\Resources\v1\Collections\PurchaseCollection;
use App\Http\Resources\v1\PurchaseResource;
use App\Http\Services\V1\PurchaseItemService;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\TryCatch;

class PurchaseController extends Controller
{
    use ApiFilter, ApiResponse;
    protected $purchaseItem;


    public function __construct(PurchaseItemService $purchaseItem)
    {
        $this->purchaseItem= $purchaseItem;
    }
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
    public function store(Request $request)
    {
            //return $request;
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
                'delivery_date' => isset($request['delivery_date']) ? $request['delivery_date'] : NULL,
                'attachment_file' => isset($request['attachment_file']) ? $request['attachment_file'] : NULL,
                'image' => isset($request['image']) ? $request['image'] : NULL,
                'status' => isset($request['status']) ? $request['status'] : '0',
                // 'payment_status' => isset($request['payment_status']) ? $request['payment_status'] : '0',

            ];
            $purchase = Purchase::create($purchaseData);
            if ($purchase) {
                if ($request->has('purchaseItems')) {

                    foreach ($request->purchaseItems as $key => $item) {
                        $item['warehouse_id']=$request['warehouse_id'];
                        $item['purchase_id']=$purchase->id;
                        if($item['is_serialized']==1){

                            for ($i=0; $i <$item['product_qty'] ; $i++) { 
                                
                                $item['generateSerialNumber']=isset($item['serial_number'][$i]) ? $item['serial_number'][$i] : $this->generateSerialNumber(8);
                                
                                $this->purchaseItem->store($item);
                            }


                        }else{
                            $this->purchaseItem->store($item);
                        }
                       
                        
                        
                    }
                   
                }
                
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

    public function generateSerialNumber($length_of_string){
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
       return substr(str_shuffle($str_result),
        0, $length_of_string);
    }
}
