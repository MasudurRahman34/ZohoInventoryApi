<?php

namespace App\Models;

use App\Enums\V1\TransactionHeadEnum;
use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Http\Controllers\Api\V1\Helper\HasUuids;
use App\Models\Scopes\ScopeUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHead extends Model
{
    use HasFactory, SoftDeletes, AccountObservant;

    protected $hidden = [
        'account_id'
    ];
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'type' => TransactionHeadEnum::class
    ];
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'head_name', 'type', 'sort', 'description', 'account_id', 'created_by', 'modified_id', 'created_at', 'deleted_at', 'updated_at',
    ];
}
