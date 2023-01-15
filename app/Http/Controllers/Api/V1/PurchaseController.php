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
use App\Http\Services\V1\PurchaseService;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\TryCatch;

class PurchaseController extends Controller
{
    use ApiFilter, ApiResponse;
    protected $purchaseItemService;
    protected $purchaseService;


    public function __construct(PurchaseItemService $purchaseItemService,PurchaseService $purchaseService)
    {
        $this->purchaseItemService= $purchaseItemService;
        $this->purchaseService= $purchaseService;
    }
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Purchase::with('supplier')->with('purchaseItems');
        $this->dateRangeQuery($request, $query, 'purchase_date');
        $purchases = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new PurchaseCollection($purchases));
    }

    public function show($uuid)
    {
        $purchase = Purchase::Uuid($uuid)->with('supplier')->with('purchaseItems')->first();
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
        
            $purchase = $this->purchaseService->store($request);
          
            if ($purchase) {
                if ($request->has('purchaseItems')) {

                    foreach ($request->purchaseItems as $key => $item) {
                        $item['warehouse_id']=$request['warehouse_id'];
                        $item['purchase_id']=$purchase->id;
                        if($item['is_serialized']==1){

                            for ($i=0; $i <$item['product_qty'] ; $i++) { 
                                
                                $item['generateSerialNumber']=isset($item['serial_number'][$i]) ? $item['serial_number'][$i] : $this->generateSerialNumber('purchase_items','serial_number',4);
                                
                                $this->purchaseItemService->store($item);
                            }


                        }else{
                            $item['serial_number'] = isset($item['serial_number'][0]) ? ($item['serial_number'][0] !=null ? $item['serial_number'][0] : $this->generateSerialNumber('purchase_items','serial_number',4)) : $this->generateSerialNumber('purchase_items','serial_number',4);
                            $this->purchaseItemService->store($item);
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
    public function delete($uuid) 
    {
     
        $purchase = Purchase::Uuid($uuid)->first();
        if ($purchase) {
            try {
                DB::beginTransaction();
                $purchase->purchaseItems()->delete();
                $purchase->delete();
                DB::commit();
                return $this->success(null, 200);
            } catch (\Throwable $th) {
               return $this->error($th->getMessage(),422);
            }
            
        } else {
            return $this->error('Data Not Found', 201);
        };
    }

    public function generateSerialNumber($table,$coloumn,$length_of_string){
    //for random string
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string= substr(str_shuffle($str_result),0, $length_of_string);

       //for next id
       $id=DB::select("SHOW TABLE STATUS LIKE '$table'");
       $next_id=$id[0]->Auto_increment;
       //with next id
       $generatekey=date("Ymd").'-'. $next_id;

       $isExistString=  DB::table($table)->where($coloumn,$generatekey)->first();
 
       if ($isExistString) {
         return $this->generateSerialNumber($table,$coloumn,$length_of_string);
       }else{
        return $string;
       }


    }

    
}
