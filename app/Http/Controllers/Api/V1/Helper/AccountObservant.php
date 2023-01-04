<?php

namespace App\Http\Controllers\Api\V1\Helper;

use App\Models\Scopes\AccountScope;
use App\Observers\AccountObserver;


trait AccountObservant{
    public static function bootAccountObservant(){
        static::observe(new AccountObserver);
        static::addGlobalScope(new AccountScope);
    }
}