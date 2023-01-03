<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SaleItem extends Model
{
    use HasFactory;
    protected $table = 'sale_items';
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
    protected $fillable = ['sale_id','warehouse_id','product_id','serial_number','product_qty','packed_qty','shipped_qty','invoice_qty','unit_price','product_discount','product_tax','subtotal','description','account_id','created_by','modified_by'
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

    public function store($saleItems, $warehouse_id, $sale_id)
        {

        for ($i = 0; $i < count($saleItems['line_id']); $i++) {
            $line_insert = array(
                'sale_id'=>$sale_id,
                'warehouse_id'=>$warehouse_id,
                "product_id" => $saleItems['product_id'][$i],
                "serial_number" => $saleItems['serial_number'][$i],
                "product_qty" => $saleItems['product_qty'][$i],
                "packed_qty" => $saleItems['packed_qty'][$i],
                "shipped_qty" => $saleItems['shipped_qty'][$i],
                "invoice_qty" => $saleItems['invoice_qty'][$i],
                "unit_price" => $saleItems['unit_price'][$i],
                "product_discount" => $saleItems['product_discount'][$i],
                "product_tax" => $saleItems['product_tax'][$i],
                "subtotal" => $saleItems['subtotal'][$i],
                "description" => $saleItems['description'][$i]

            );
            $response = SaleItem::create($line_insert);

        }
        return $response;
    }

    
}
