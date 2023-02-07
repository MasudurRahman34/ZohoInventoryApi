<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feature;

class Plan extends Model
{
    use HasFactory;

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'plan_feature_permissions', 'plan_id', 'feature_id')->withPivot('access', 'access_value');
    }
}
