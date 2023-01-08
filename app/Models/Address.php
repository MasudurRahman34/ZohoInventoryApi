<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Models\Location\District;
use App\Models\Location\State;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes, AccountObservant;

    public static $ref_supplier_key = "App\Models\Suppliers";
    public static $ref_customer_key = "App\Models\Customers";
    public static $ref_user_key = "App\Models\Users";

    protected $table = 'portal_address';
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
        'ref_object_key', 'ref_id', 'attention', 'country_id', 'state_id', 'district_id', 'thana_id', 'union_id', 'zipcode_id', 'street_address_id', 'house', 'phone', 'fax', 'is_bill_address', 'is_ship_address', 'full_address', 'status', 'created_by', 'modified_by', 'account_id'
    ];

   
}
