<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\V1\PurchaseItemService;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class PurchaseItemController extends Controller
{
    use ApiResponse;
    protected $purchaseItemService;

    public function __construct(PurchaseItemService $purchaseItemService)
    {
        $this->purchaseItemService = $purchaseItemService;
    }



    public function showBySerialNumber($serialNumber)
    {

        return $this->purchaseItemService->showBySerialNumber($serialNumber);
    }

    public function delete($id)
    {
        $purchaseItem = PurchaseItem::find($id);
        if ($purchaseItem) {
            $purchaseItem->delete();
            return $this->success(null, '', 200);
        } else {
            return $this->error('Data Not Found', 404);
        };
    }
}
