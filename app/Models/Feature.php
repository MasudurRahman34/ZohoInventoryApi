<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;

class Feature extends Model
{

    use HasFactory;
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_feature_permissions', 'feature_id', 'plan_id')->withPivot('access', 'access_value');
    }
}
