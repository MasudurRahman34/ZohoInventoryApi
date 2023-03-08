<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdjustmentItem extends Model
{
    use HasFactory, SoftDeletes, AccountObservant;
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
        'inventory_adjustment_id', 'product_id', 'product_name', 'warehouse_id', 'item_adjustment_date', 'quantity', 'quantity_available', 'new_quantity_on_hand', 'description', 'status', 'account_id', 'created_by', 'modified_by', 'updated_at', 'deleted_at'
    ];

    public function inventoryAdjustment()
    {
        return $this->belongsTo(InventoryAdjustment::class, 'inventory_adjustment_id', 'id');
    }
}
