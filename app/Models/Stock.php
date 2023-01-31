<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes, AccountObservant;
    protected $table = 'stocks';
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
        'product_id', 'warehouse_id', 'date', 'quantity', 'purchase_quantity', 'sale_quantity', 'quantity_on_hand', 'opening_stock_value', 'account_id', 'created_by', 'modified_by'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
