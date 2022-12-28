<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GlobalAddress extends Model
{
    use HasFactory;
    protected $table = 'global_address';
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $casts = [
        'full_address' => 'array'
    ];
    protected $fillable = [
        'country_id', 'state_id', 'district_id', 'thana_id', 'union_id', 'zipcode_id', 'street_address_id', 'address','full_address', 'status', 'created_by', 'modified_by', 'account_id'
    ];
    protected static function boot()
    {
        parent::boot();

        // auto-sets account values on creation
        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->account_id = Auth::user()->account_id;
        });
    }

}
