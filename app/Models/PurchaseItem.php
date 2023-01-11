<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PurchaseItem extends Model
{
    use HasFactory,SoftDeletes,AccountObservant;
    protected $table = 'purchase_items';
    protected $hidden=[
        'account_id'
    ];
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    // protected $casts = [
    //     'full_address' => 'array'
    // ];
    protected $fillable = ['purchase_id','warehouse_id','product_id','serial_number','product_qty','received_qty','unit_price','product_discount','product_tax','package_date','is_serialized','expire_date','subtotal','description','account_id','created_by','modified_by'
    ];
    

    public function store($purchaseItems, $warehouse_id, $purchase_id)
        {

       
            $line_insert = array(
                'purchase_id'=>$purchase_id,
                'warehouse_id'=>$warehouse_id,
                "product_id" => $purchaseItems['product_id'],
                "product_qty" => $purchaseItems['product_qty'],
                "received_qty" => $purchaseItems['received_qty'],
                "unit_price" => $purchaseItems['unit_price'],
                "product_discount" => $purchaseItems['product_discount'],
                "product_tax" => $purchaseItems['product_tax'],
                "subtotal" => $purchaseItems['subtotal'],
                "description" => $purchaseItems['description']

            );
            $response = PurchaseItem::create($line_insert);

        
        return $response;
    }

    
}
