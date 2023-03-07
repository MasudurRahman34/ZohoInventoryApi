<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\PurchaseRequest;
use App\Http\Resources\v1\Collections\PurchaseCollection;
use App\Http\Resources\v1\PurchaseResource;
use App\Http\Services\V1\AdjustmentItemService;
use App\Http\Services\V1\CalculateProductPriceService;
use App\Http\Services\V1\InventoryAdjustmentService;
use App\Http\Services\V1\PurchaseItemService;
use App\Http\Services\V1\PurchaseService;
use App\Models\AdjustmentItem;
use App\Models\InventoryAdjustment;
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
    protected $inventoryAdjustment;
    protected $adjustmentItemService;
    protected $calculateProductPriceService;


    public function __construct(PurchaseItemService $purchaseItemService, PurchaseService $purchaseService, InventoryAdjustmentService $inventoryAdjustment, AdjustmentItemService $adjustmentItemService, CalculateProductPriceService $calculateProductPriceService)
    {
        $this->purchaseItemService = $purchaseItemService;
        $this->purchaseService = $purchaseService;
        $this->inventoryAdjustment = $inventoryAdjustment;
        $this->calculateProductPriceService = $calculateProductPriceService;
        $this->adjustmentItemService = $adjustmentItemService;
    }
    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        $query = Purchase::with('supplier')->with('purchaseItems')->with('inventoryAdjustment');
        $this->dateRangeQuery($request, $query, 'purchase_date');
        $purchases = $this->query->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return (new PurchaseCollection($purchases));
    }

    public function show($uuid)
    {
        $purchase = Purchase::Uuid($uuid)->with('supplier')->with('purchaseItems')->with('inventoryAdjustment')->first();
        if ($purchase) {
            return $this->success(new PurchaseResource($purchase));
        } else {
            return $this->error('Data Not Found', 404);
        }
    }


    public function store(PurchaseRequest $request)
    {

        $request = $this->calculateProductPriceService->purchasePrice($request->all());
        //return $request;
        DB::beginTransaction();
        try {

            $purchase = $this->purchaseService->store($request);
            // return $purchase;

            if ($purchase) {
                $inventoryAdjustment = [];
                if (count($request['purchaseItems']) > 0) {

                    foreach ($request['purchaseItems'] as $key => $item) {
                        //return $key;
                        $item['warehouse_id'] = $request['warehouse_id'];
                        $item['purchase_id'] = $purchase->id;
                        if ($item['is_serialized'] == 1) {
                            $item['group_number'] = $this->generateKey('purchase_items', 'group_number', 6);
                            for ($i = 0; $i < $item['product_qty']; $i++) {

                                $item['generateSerialNumber'] = isset($item['serial_number'][$i]) ? $item['serial_number'][$i] : $this->generateKey('purchase_items', 'serial_number', 6);

                                $this->purchaseItemService->store($item);
                            }
                        } else {
                            //$item['serial_number'] = isset($item['serial_number'][0]) ? ($item['serial_number'][0] != null ? $item['serial_number'][0] : $this->generateKey('purchase_items', 'serial_number', 4)) : $this->generateKey('purchase_items', 'serial_number', 4);
                            $item['serial_number'] = isset($item['serial_number'][0]) ? null : null;
                            $this->purchaseItemService->store($item);
                        }

                        //inventory adjustment item
                        $inventoryAdjustment['adjustmentItems'][$key]['product_id'] = $item['product_id'];
                        $inventoryAdjustment['adjustmentItems'][$key]['product_name'] = isset($item['product_name']) ? $item['product_name'] : NULL;
                        $inventoryAdjustment['adjustmentItems'][$key]['warehouse_id'] = $item['warehouse_id'];
                        $inventoryAdjustment['adjustmentItems'][$key]['item_adjustment_date'] = $purchase->purchase_date;
                        $inventoryAdjustment['adjustmentItems'][$key]['quantity'] = $item['product_qty'];
                        $inventoryAdjustment['adjustmentItems'][$key]['quantity_available'] = 0;
                        $inventoryAdjustment['adjustmentItems'][$key]['new_quantity_on_hand'] = 0;
                        $inventoryAdjustment['adjustmentItems'][$key]['description'] = 'Item adjustment based on purchased';
                        $inventoryAdjustment['adjustmentItems'][$key]['status'] = 0;
                    }
                    //inventory adjustment
                    $inventoryAdjustment['source'] = 'purchase';
                    $inventoryAdjustment['mode_of_adjustment'] = 1;
                    $inventoryAdjustment['reference_number'] = $purchase->reference;
                    $inventoryAdjustment['adjustment_date'] = $purchase->purchase_date;
                    $inventoryAdjustment['account'] = 0;
                    $inventoryAdjustment['reason_id'] = 7; //billed
                    $inventoryAdjustment['warehouse_id'] = $request['warehouse_id'];
                    $inventoryAdjustment['description'] = 'Item adjustment based on purchased';
                    $inventoryAdjustment['inventory_adjustmentable_id'] = $purchase->id;
                    //storing inventory adjustment and adjustment items
                    $this->inventoryAdjustment->store($inventoryAdjustment);
                }
            }
            DB::commit();

            $purchase = Purchase::with('purchaseItems')->with('inventoryAdjustment')->find($purchase->id);

            return $this->success(new PurchaseResource($purchase), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(throw $e, 200);
        }
    }
    public function update(PurchaseRequest $request, $uuid)
    {   //overriding and calculating purchase data
        //return $request; 
        DB::beginTransaction();
        try {
            $purchase = Purchase::Uuid($uuid)->with('purchaseItems')->with('inventoryAdjustment')->first();
            $purchaseItemsWithoutSerialized = PurchaseItem::where('purchase_id', $purchase->id)->where('is_serialized', 0)->delete();

            if ($purchase) {
                $inventoryAdjustment = InventoryAdjustment::where('inventory_adjustmentable_id', $purchase->id)->where('inventory_adjustmentable_type', InventoryAdjustment::$purchase_table)->first();
                $request = $this->calculateProductPriceService->purchasePrice($request->all());
                $updatedPurchase = $this->purchaseService->update($request, $purchase);

                //return $updatedPurchase;

                if ($updatedPurchase) {


                    $inventoryAdjustmentItem = [];
                    if (count($request['purchaseItems']) > 0) {

                        foreach ($request['purchaseItems'] as $key => $item) {
                            //return $key;
                            $item['warehouse_id'] = $request['warehouse_id'];
                            $item['purchase_id'] = $purchase->id;
                            if ($item['is_serialized'] == 1) {
                                $isExistSerializedItem = PurchaseItem::where('purchase_id', $purchase->id)->where('product_id', $item['product_id'])->where('is_serialized', 1)->get();
                                $remain_quantity = $item['product_qty'] - count($isExistSerializedItem);
                                if (count($isExistSerializedItem) > 0) {
                                    //update existing seriliazed items
                                    foreach ($isExistSerializedItem as $serilizeItem) {
                                        if ($serilizeItem['status'] != 1) { //update except sold product
                                            $item['product_qty'] = 1;
                                            $this->purchaseItemService->update($item, $serilizeItem);
                                        }
                                    }

                                    //delete if remain_quanity = existinQunatity-Item[quantity]
                                    if ($remain_quantity < 0) {
                                        $loopWhile = abs($remain_quantity);
                                        $x = 0; //initial 
                                        while ($x < $loopWhile) {
                                            if ($isExistSerializedItem[$x]->status != 1) { //delete except sold product
                                                $this->purchaseItemService->delete($isExistSerializedItem[$x]->id);
                                            }
                                            $x++;
                                        }
                                    }
                                    //add items when remain_quantity greater than exist
                                    if ($remain_quantity > 0) {
                                        $item['group_number'] = $this->generateKey('purchase_items', 'group_number', 6);
                                        for ($i = 0; $i < $remain_quantity; $i++) {

                                            $item['generateSerialNumber'] = isset($item['serial_number'][$i]) ? $item['serial_number'][$i] : $this->generateKey('purchase_items', 'serial_number', 6);

                                            $this->purchaseItemService->store($item);
                                        }
                                    }
                                } else {  //not exist store serialized
                                    $item['group_number'] = $this->generateKey('purchase_items', 'group_number', 6);
                                    for ($i = 0; $i < $item['product_qty']; $i++) {

                                        $item['generateSerialNumber'] = isset($item['serial_number'][$i]) ? $item['serial_number'][$i] : $this->generateKey('purchase_items', 'serial_number', 6);

                                        $this->purchaseItemService->store($item);
                                    }
                                }
                            } else {

                                $isExistItem = PurchaseItem::withTrashed()->where('purchase_id', $purchase->id)->where('product_id', $item['product_id'])->first();
                                if ($isExistItem) {

                                    $this->purchaseItemService->update($item, $isExistItem);
                                } else {
                                    //return $item[$key];
                                    $item['serial_number'] = isset($item['serial_number'][0]) ? null : null;
                                    $this->purchaseItemService->store($item);
                                }
                            }



                            if ($inventoryAdjustment) {
                                $adjustmentItems = [];
                                $adjustmentItems['inventory_adjustment_id'] = $inventoryAdjustment->id;
                                $adjustmentItems['product_id'] = $item['product_id'];
                                $adjustmentItems['product_name'] = isset($item['product_name']) ? $item['product_name'] : NULL;
                                $adjustmentItems['warehouse_id'] = $item['warehouse_id'];
                                $adjustmentItems['item_adjustment_date'] = $purchase->purchase_date;
                                $adjustmentItems['quantity'] = $item['product_qty'];
                                $adjustmentItems['quantity_available'] = 0;
                                $adjustmentItems['new_quantity_on_hand'] = 0;
                                $adjustmentItems['description'] = 'Item adjustment update based on purchased';
                                $adjustmentItems['status'] = 0;
                                //check item exist in adjustment item
                                $adjustmentItem = AdjustmentItem::where('inventory_adjustment_id', $inventoryAdjustment->id)->where('product_id', $item['product_id'])->first(); //check adjustment item exist or not

                                if ($adjustmentItem) {
                                    //update if exist adjustment item
                                    $this->adjustmentItemService->update($adjustmentItems, $adjustmentItem);
                                } else {
                                    //store if not exsist inventory adjustment item
                                    $this->adjustmentItemService->store($adjustmentItems);
                                }
                            }
                        } //end foreach
                    }
                }
            } else {
                return $this->error('Data Not Found', 201);
            }

            DB::commit();
            $purchase->refresh();
            return $purchase;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 200);
        }
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
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error('Data Not Found', 201);
        };
    }

    public function generateKey($table, $coloumn, $length_of_string)
    {
        //for random string
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string = substr(str_shuffle($str_result), 0, $length_of_string);
        $generateStringkey = date("Ymd") . '-' . $string;
        $isExistString =  DB::table($table)->where($coloumn, $generateStringkey)->first();

        if ($isExistString) {
            return $this->generateKey($table, $coloumn, $length_of_string);
        } else {
            return $generateStringkey;
        }
    }
}
