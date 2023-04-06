<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;
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
        'id', 'group', 'description', 'sort', 'default', 'status', 'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_groups_id', 'id');
    }
}
