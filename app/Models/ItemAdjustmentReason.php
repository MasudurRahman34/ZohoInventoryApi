<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAdjustmentReason extends Model
{
    use HasFactory,SoftDeletes,AccountObservant;
    protected $hidden = [
        'account_id'
    ];
    protected $dates=[
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];

    public function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
 
     protected $fillable=[
            'reason_name','desription','account_id','modified_by','created_by'
     ];

     public function inventoryAdjustment(){
        return $this->belongsTo(InventoryAdjustment::class,'reason_id','id');
     }
}
