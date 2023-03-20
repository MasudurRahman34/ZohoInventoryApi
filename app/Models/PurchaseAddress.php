<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rules\Enum;

class PurchaseAddress extends Model
{
    use HasFactory, SoftDeletes, AccountObservant;

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
    protected $casts = [
        'full_address' => 'array',
    ];

    protected $fillable = [
        'purchase_id', 'addressable_type', 'type', 'addressable_id', 'deliver_to', 'attention', 'display_name', 'company_name', 'company_info', 'company_logo', 'first_name', 'last_name', 'mobile', 'mobile_country_code', 'email', 'phone', 'fax', 'website', 'tax_number',
        'country_id', 'country_name', 'state_name', 'district_name', 'thana_name', 'union_name', 'zipcode', 'street_address_line_1', 'street_address_line_2', 'house',
        'full_address', 'plain_address', 'status', 'created_by', 'modified_by', 'account_id', 'updated_at', 'deleted_at'
    ];
}
