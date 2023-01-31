<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Models\Scopes\ScopeUuid;
use DateTimeInterface;
use App\Http\Controllers\Api\V1\Helper\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes, HasUuids, AccountObservant, ScopeUuid;
    protected $table = 'warehouses';
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
        'uuid', 'name', 'code', 'phone_country_code', 'mobile_country_code', 'phone', 'mobile', 'email', 'description', 'address', 'current_balance', 'account_id', 'created_by', 'modified_by'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'warehouse_id', 'id');
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'warehouse_id');
    }
}
