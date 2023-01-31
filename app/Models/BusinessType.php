<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessType extends Model
{
    use HasFactory, SoftDeletes;
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
        'type_name',
        'category_type',
        'parent_id',
        'status',
        'account_id',
        'created_by',
        'modified_by',
    ];
    public static function nextId()
    {
        return static::max('id') + 1;
    }

    public function parent()
    {
        return $this->belongsTo(BusinessType::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(BusinessType::class, 'parent_id');
    }
    public function childRecursive()
    {
        return $this->child()->with('childRecursive');
    }

    // public function accounts()
    // {
    //     return $this->belongsToMany(Accounts::class, 'account_business_type', 'account_id', 'business_type_id');
    // }
}
