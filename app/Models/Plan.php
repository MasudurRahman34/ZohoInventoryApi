<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feature;
use App\Models\PlanPrice;
use DateTimeInterface;

class Plan extends Model
{
    use HasFactory;
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
    protected $hidden = ['pivot'];
    protected $fillable = [
        'plan_name', 'business_type', 'status', 'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at',

    ];
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'plan_feature_permissions', 'plan_id', 'feature_id');
    }

    public function pricesTypes()
    {
        return $this->belongsToMany(PriceType::class, 'plan_prices', 'plan_id', 'price_types_id');
    }
}
