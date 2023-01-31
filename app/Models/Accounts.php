<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Auth;

class Accounts extends Model
{
    use HasFactory, SoftDeletes, IdIncreamentable, HasUuids;
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'module_name' => 'array'
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $fillable = [
        'uuid', 'account_number', 'account_uri', 'company_name', 'slug', 'compnay_logo', 'module_name', 'dashboard_blocks', 'language', 'ip_address_access', 'domain', 'host', 'database_name', 'database_user', 'database_password', 'account_super_admin', 'user_id', 'created_by', 'modified_by'
    ];

    public static $rules = [
        'company_name' => 'required|string|max:255',
        'module_name' => 'required|array',
    ];

    public function IdIncreamentable(): array
    {
        return [
            'source' => 'id',
            'prefix' => 'BDERP' . date("y") . date("m") . date('d'),
            'attribute' => 'account_number',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function businessTypes()
    {
        return $this->belongsToMany(BusinessType::class)->distinct();
    }
}
