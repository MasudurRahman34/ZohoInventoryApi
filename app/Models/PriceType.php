<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;

class PriceType extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_prices', 'price_types_id', 'plan_id');
    }
}
