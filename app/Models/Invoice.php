<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\HasUuids;
use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\InvoiceReceiverAddress;
use App\Models\InvoiceSenderAddress;

class Invoice extends Model
{

    use HasFactory, SoftDeletes, HasUuids, IdIncreamentable;
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
        'uuid', 'customer_id', 'customer_name', 'salesperson', 'shipping_address',
        'billing_address', 'invoice_number', 'short_code', 'order_id',
        'order_number', 'invoice_date', 'due_date', 'order_tax',
        'order_tax_amount', 'order_discount', 'discount_type',
        'shipping_charge', 'order_adjustment', 'total_amount',
        'total_tax', 'invoice_description', 'balance',
        'grand_total_amount', 'due_amount', 'paid_amount', 'change_amount',
        'last_paid', 'adjustment_text', 'invoice_terms', 'invoice_type',
        'invoice_currency', 'status',
        'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at',

    ];
    public function IdIncreamentable(): array
    {
        return [
            'source' => 'id',
            'prefix' => 'INV' . date("y") . date("m") . date('d'),
            'attribute' => 'invoice_number',
        ];
    }

    public function invoiceItems()
    {
        return $this->hasMany(invoiceItem::class, 'invoice_id', 'id');
    }

    public function recieverAddress()
    {
        return $this->belongsTo(InvoiceReceiverAddress::class, 'id', 'invoice_id');
    }
    public function senderAddress()
    {
        return $this->belongsTo(InvoiceSenderAddress::class, 'id', 'invoice_id');
    }
}
