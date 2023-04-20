<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, SoftDeletes;

    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'id', 'name', 'permission_groups_id', 'guard_name','title', 'description', 'sort', 'is_global', 'status', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function accountPermission()
    {
        return $this->belongsTo(AccountPermission::class, 'id');
    }
}
