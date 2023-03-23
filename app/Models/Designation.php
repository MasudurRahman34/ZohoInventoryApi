<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
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

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'name', 'sort', 'description', 'default', 'account_id', 'created_by', 'modified_id', 'created_at', 'deleted_at', 'updated_at',
    ];
}
