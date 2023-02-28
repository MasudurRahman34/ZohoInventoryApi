<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

trait ScopeUuid
{
    public static function scopeUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }
}
