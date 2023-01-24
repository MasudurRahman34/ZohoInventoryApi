<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseAddress extends Model
{
    use HasFactory,SoftDeletes,AccountObservant;
   
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
    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
    ];

    protected $fillable = [
        'supplier_id','purchase_id','display_name','company_name','attension','billing_address','shipping_address','account_id','created_by','modified_by'
    ];
}
