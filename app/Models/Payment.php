<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    public static $paymetableType = [
        'invoice' => "App\Models\Invoice",
        'bill' => "App\Models\Bill",
        'sale' => "App\Models\Sale",
    ];

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

    protected $fillable = [
        'id', 'paymentable_type', 'paymentable_id', 'payment_date', 'reference', 'total_amount', 'paid_by', 'payment_method', 'payment_method_number', 'type', 'status', 'is_thankyou', 'note', 'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function paymentable()
    {
        return $this->morphTo();
    }

    // public function bill()
    // {
    //     return $this->belongsTo(Bill::class, 'media_id', 'id');
    // }
}
