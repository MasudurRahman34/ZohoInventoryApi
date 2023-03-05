<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AccountScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $account_id = Auth::guard('api')->check() ? (Auth::guard('api')->user()->account_id != null ? Auth::guard('api')->user()->account_id : 1)  : 1;
        $builder->where($model->getTable() . '.account_id', $account_id);
    }
}
