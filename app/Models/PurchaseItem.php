<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Models\Location\State;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PurchaseItem extends Model
{
    use HasFactory, SoftDeletes, AccountObservant;
    protected $table = 'purchase_items';
    protected $hidden = [
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

    protected $fillable = [
        'purchase_id', 'warehouse_id', 'product_id', 'product_name', 'sku', 'serial_number', 'group_number', 'product_qty', 'received_qty', 'sold_qty', 'unit_price', 'product_discount', 'tax_name', 'tax_rate', 'tax_amount', 'whole_price', 'subtotal', 'package_date', 'is_serialized', 'expire_date',
        'description', 'account_id', 'created_by', 'modified_by', 'updated_at', 'deleted_at', 'created_at',
        'status', 'is_taxable'
    ];

    public function product()
    {
        return 'belongsTo(Product::class, product_id, id)';
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }
    // public function stock()
    // {
    //     return $this->belongsTo(Stock::class, 'product_id', 'product_id');
    // }
}
