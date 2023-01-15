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

    protected $fillable = [
        'purchase_id','warehouse_id','product_id','serial_number','product_qty','received_qty','unit_price','product_discount','product_tax','package_date','is_serialized','expire_date','subtotal','description','account_id','created_by','modified_by'
    ];

    
}
