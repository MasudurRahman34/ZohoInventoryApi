<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'full_address' => 'array'
    ];
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'invoice_id', 'product_id', 'product_name', 'serial_number', 'group_number', 'product_description',
        'warehouse_id', 'order_id', 'order_number', 'product_qty', 'unit_price',
        'product_discount', 'tax_name', 'tax_rate', 'tax_amount', 'whole_price', 'subtotal', 'is_taxable', 'is_serialized', 'account_id',
        'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at', 'service_date'
    ];
}
