<?php

namespace App\Http\Controllers\Api\V1\Helper;

use App\Models\Scopes\AccountScope;
use App\Observers\AccountObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

trait AccountObservant{
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => [
                'created_at'=>$value,
                'human_date'=>Carbon::parse($value)->diffForHumans(), 
            ],
        );
    }
    public static function bootAccountObservant(){
        static::observe(new AccountObserver);
        static::addGlobalScope(new AccountScope);
    }
}