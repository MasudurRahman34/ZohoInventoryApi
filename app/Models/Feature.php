<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;

class Feature extends Model
{

    use HasFactory;
    // protected $hidden = ['pivot'];
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_features', 'feature_id', 'plan_id');
    }
}
