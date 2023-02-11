<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceReceiverAddress extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = [
        'account_id',
    ];
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
        'invoice_id', 'attention', 'display_name', 'company_name', 'first_name', 'last_name', 'mobile', 'mobile_country_code', 'email', 'phone', 'fax',
        'country_id', 'state_id', 'district_id', 'thana_id', 'union_id', 'zipcode_id', 'street_address_id', 'house',
        'full_address', 'plain_address', 'status', 'created_by', 'modified_by', 'account_id', 'company_info',
    ];
}
