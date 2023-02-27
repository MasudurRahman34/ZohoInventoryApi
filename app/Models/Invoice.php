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
use Illuminate\Contracts\Mail\Attachable;

class Invoice extends Model
{


    use HasFactory, SoftDeletes, HasUuids;
    public static $INVOICE_FILE_PATH = "public/uploads/invoice/";
    protected $appends = ['pdf_full_link', 'download_pdf_url'];



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
        'account_id', 'created_by', 'modified_by', 'created_at', 'updated_at', 'deleted_at', 'download', 'user_ip', 'pdf_link', 'total_whole_amount', 'payment_term', 'total_product_discount'

    ];
    // public function IdIncreamentable(): array
    // {
    //     return [
    //         'source' => 'id',
    //         'prefix' => 'INV' . date("y") . date("m") . date('d'),
    //         'attribute' => 'invoice_number',
    //     ];
    // }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function receiverAddress()
    {
        return $this->belongsTo(InvoiceAddress::class, 'id', 'invoice_id')->where('addressable_type', 'receiver');
    }
    public function senderAddress()
    {
        return $this->belongsTo(InvoiceAddress::class, 'id', 'invoice_id')->where('addressable_type', 'sender');
    }

    public function getPdfFullLinkAttribute()
    {

        return \asset($this->pdf_link);
    }

    public function getDownloadPdfUrlAttribute()
    {
        return env('APP_URL') . '/api/v1/invoices' . '/' . $this->short_code . '/download';
    }

    // public function attachments()
    // {

    //     return $this->hasMany(Attachment::class, 'attachmentable_id', 'id')->where('attachmentable_type', Media::$MEDIA_REFERENCE_TABLE['invoice'])->with('media');
    // }

    // public function attachments()
    // {
    //     return $this->morphMany(Attachment::class, 'attachmentable')->with(['media' => function ($query) {
    //         $query->select('id', 'short_link');
    //     }])->select('id', 'attachmentable_id', 'media_id');
    // }

    public function media()
    {
        return $this->morphToMany(Media::class, 'attachmentable', Attachment::class)->withPivot('id')->where('attachments.deleted_at', NULL);
    }
}
