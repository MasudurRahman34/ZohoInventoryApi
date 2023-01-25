<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Models\Scopes\ScopeUuid;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Purchase extends Model
{
    use HasFactory,SoftDeletes,HasUuids,AccountObservant,ScopeUuid;
    protected $table = 'purchases';
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
    protected $fillable = [
       'id','uuid', 'supplier_id', 'warehouse_id', 'invoice_no', 'reference', 'total_amount', 'due_amount', 'paid_amount', 'grand_total_amount','order_discount', 'discount_currency', 'order_tax', 
        'order_tax_amount', 'shipping_charge','order_adjustment','last_paid_amount','adjustment_text','purchase_date',
        'delivery_date','attachment_file','image','status','payment_status','account_id','created_by','modified_by'
    ];


    public function purchaseItems(){
        return $this->hasMany(PurchaseItem::class,'purchase_id','id');

    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function inventoryAdjustment(){
        return $this->morphOne(InventoryAdjustment::class,'inventory_adjustmentable')->with('adjustmentItems');
    }
    // public function getRouteKey()
    // {
    //     return 'uuid';
    // }
    
}
