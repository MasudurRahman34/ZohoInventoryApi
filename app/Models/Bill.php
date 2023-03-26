<?php

namespace App\Models;

use App\Enums\V1\BillEnum;
use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Http\Controllers\Api\V1\Helper\HasUuids;
use App\Models\Scopes\ScopeUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes, HasUuids, AccountObservant, ScopeUuid;
    public static $BILL_FILE_PATH = "public/uploads/bill/";
    protected $dates = [
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'order_id' => 'json',
        'order_number' => 'json',
        'status' => BillEnum::class
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'uuid', 'supplier_id', 'supplier_name', 'billing_person', 'shipping_address',
        'billing_address', 'bill_number', 'short_code', 'order_id',
        'order_number', 'bill_date', 'due_date', 'order_tax',
        'order_tax_amount', 'order_discount', 'discount_amount',
        'shipping_charge', 'order_adjustment', 'total_amount',
        'total_tax', 'bill_description', 'balance',
        'grand_total_amount', 'due_amount', 'paid_amount', 'change_amount',
        'last_paid', 'adjustment_text', 'bill_terms', 'bill_type',
        'bill_currency', 'status',
        'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at', 'download', 'user_ip', 'pdf_link', 'total_whole_amount', 'payment_term', 'total_product_discount'

    ];

    public function billItems()
    {
        return $this->hasMany(BillItem::class, 'bill_id', 'id');
    }

    public function receiverAddress()
    {
        return $this->belongsTo(BillAddress::class, 'id', 'bill_id')->where('addressable_type', 'receiver');
    }
    public function senderAddress()
    {
        return $this->belongsTo(BillAddress::class, 'id', 'bill_id')->where('addressable_type', 'sender');
    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'attachmentable', Attachment::class)->withPivot('id')->where('attachments.deleted_at', NULL);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }
}
