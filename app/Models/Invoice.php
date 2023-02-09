<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\HasUuids;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{

    use HasFactory, SoftDeletes, HasUuids;
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'order_id' => 'array',
        'order_number' => 'array'
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
