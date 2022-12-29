<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchaseItem extends Model
{
    use HasFactory;
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
    protected $fillable = ['purchase_id','warehouse_id','product_id','serial_number','product_qty','received_qty','unit_price','product_discount','product_tax','subtotal','description','account_id','created_by','modified_by'
    ];
    protected static function boot()
    {
        parent::boot();

        // auto-sets account values on creation
        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->account_id = Auth::user()->account_id;
        });
    }

    public function store($purchaseItems, $warehouse_id, $purchase_id)
        {

        for ($i = 0; $i < count($purchaseItems['line_id']); $i++) {
            $line_insert = array(
                'purchase_id'=>$purchase_id,
                'warehouse_id'=>$warehouse_id,
                "product_id" => $purchaseItems['product_id'][$i],
                "serial_number" => $purchaseItems['serial_number'][$i],
                "product_qty" => $purchaseItems['product_qty'][$i],
                "received_qty" => $purchaseItems['received_qty'][$i],
                "unit_price" => $purchaseItems['unit_price'][$i],
                "product_discount" => $purchaseItems['product_discount'][$i],
                "product_tax" => $purchaseItems['product_tax'][$i],
                "subtotal" => $purchaseItems['subtotal'][$i],
                "description" => $purchaseItems['description'][$i]

            );
            $response = PurchaseItem::create($line_insert);

        }
        return $response;
    }

    
}
