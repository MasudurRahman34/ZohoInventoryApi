<?php

namespace App\Models\Location;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Union extends Model
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
        'thana_id', 'union_name', 'union_slug', 'sort', 'status', 'created_at', 'deleted_at', 'updated_at'
    ];
}
