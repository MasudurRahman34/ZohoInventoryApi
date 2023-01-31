<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountBusinessType extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = "account_business_type";
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
        'account_id', 'business_type_id',
    ];

    public static $rules = [
        'company_name' => 'required|string|max:255',
        'module_name' => 'required|array',
    ];
}
