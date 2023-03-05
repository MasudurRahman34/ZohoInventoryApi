<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillAddress extends Model
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
        'bill_id', 'addressable_type', 'attention', 'display_name', 'company_name', 'company_info', 'company_logo', 'first_name', 'last_name', 'mobile', 'mobile_country_code', 'email', 'phone', 'fax', 'website', 'tax_number',
        'country_id', 'country_name', 'state_name', 'district_name', 'thana_name', 'union_name', 'zipcode', 'street_address_line_1', 'street_address_line_2', 'house',
        'full_address', 'plain_address', 'status', 'created_by', 'modified_by', 'account_id',
    ];
}
