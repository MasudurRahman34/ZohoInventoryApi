<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Observers\AccountObserver;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Guard;

class Role extends SpatieRole
{
    use HasFactory, SoftDeletes;
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    protected $hidden = ['pivot'];
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'id', 'name', 'guard_name', 'description', 'sort', 'default', 'status', 'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    // public static function create(array $attributes = [])
    // {
    //     $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

    //     $params = ['name' => $attributes['name'], 'guard_name' => $attributes['guard_name']];

    //     if (static::findByParam($params)) {
    //         throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
    //     }

    //     return static::query()->create($attributes);
    // }

    // protected static function findByParam(array $params = [])
    // {
    //     $query = static::query();


    //     foreach ($params as $key => $value) {
    //         $query->where($key, $value)->where('account_id', Auth::user()->account_id);
    //     }

    //     return $query->first();
    // }

    protected static function boot()
    {
        parent::boot();

        static::observe(AccountObserver::class);
    }
}
