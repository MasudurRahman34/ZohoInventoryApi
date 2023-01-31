<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Models\Scopes\ScopeUuid;
use DateTimeInterface;
use App\Http\Controllers\Api\V1\Helper\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Sale extends Model
{
    use HasFactory, SoftDeletes, AccountObservant, HasUuids, ScopeUuid;
    protected $table = 'sales';
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
    // protected $casts = [
    //     'full_address' => 'array'
    // ];
    protected $fillable = [
        'uuid', 'customer_id', 'warehouse_id', 'order_number', 'sales_order_date', 'expected_shipment_date', 'billing_address', 'shipping_address', 'delivery_method', 'reference', 'order_discount', 'discount_currency',
        'order_discount_amount', 'order_tax', 'order_tax_amount', 'shipping_charge', 'order_adjustment', 'adjustment_text',
        'customer_note', 'terms_condition', 'total_amount', 'grand_total_amount', 'due_amount', 'paid_amount', 'recieved_amount', 'changed_amount',
        'last_paid_amount', 'attachment_file', 'image', 'offer_to', 'offer_subject', 'offer_greetings', 'offer_terms_condition', 'invoice_status', 'shipment_status',
        'status', 'payment_status', 'sales_type', 'salesperson', 'account_id', 'created_by', 'modified_by'
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
