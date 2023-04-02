<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Http\Controllers\Api\V1\Helper\HasUuids;
use App\Models\Scopes\ScopeUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuids, ScopeUuid, AccountObservant;

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
        'id', 'uuid', 'group_id', 'item_category_id', 'item_category_id', 'item_company_id', 'item_model_id',
        'item_name', 'item_slug', 'sku', 'measurment', 'unit', 'length', 'width', 'height', 'weight', 'weight_unit',
        'manufacturar', 'universal_product_barcode', 'mpn', 'isbn', 'ean',
        'reorder_point', 'sort', 'is_serialized', 'is_returnable', 'type', 'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at'
    ];


    public function stock()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id');
    }
}
