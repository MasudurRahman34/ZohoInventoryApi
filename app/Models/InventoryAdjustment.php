<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Models\Scopes\ScopeUuid;
use DateTimeInterface;
use App\Http\Controllers\Api\V1\Helper\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryAdjustment extends Model
{
    use HasFactory, SoftDeletes, AccountObservant, HasUuids, ScopeUuid;
    public static $purchase_table = "App\Models\Purchase";
    public static $sale_table = "App\Models\Sale";
    public static $inventory_adjustment_table = "App\Models\InventoryAdjustment";
    protected $table = 'inventory_adjustments';
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
        'id', 'uuid', 'mode_of_adjustment', 'inventory_adjustmentable_id', 'inventory_adjustmentable_type',
        'reference_number', 'adjustment_date', 'account', 'reason_id', 'warehouse_id',
        'description', 'account_id',
        'created_by', 'modified_by',

    ];

    public function inventory_adjustmentable()
    {
        return $this->morphTo();
    }
    public function itemAdjustmentReason()
    {
        return $this->belongsTo(ItemAdjustmentReason::class, 'reason_id', 'id');
    }

    public function adjustmentItems()
    {
        return $this->hasMany(AdjustmentItem::class, 'inventory_adjustment_id', 'id');
    }

    public static function nextId()
    {
        return static::max('id') + 1;
    }
}
