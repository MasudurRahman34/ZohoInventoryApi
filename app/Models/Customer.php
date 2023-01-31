<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;
use App\Models\Scopes\ScopeUuid;
use DateTimeInterface;
use App\Http\Controllers\Api\V1\Helper\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{

    use HasFactory, SoftDeletes, AccountObservant, HasUuids, ScopeUuid;

    protected $table = 'portal_customers';
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

    protected $fillable = [
        'customer_number', 'uuid', 'copy_bill_address', 'customer_type', 'display_name', 'company_name', 'website', 'tax_name', 'tax_rate', 'currency', 'image', 'payment_terms', 'account_id', 'created_by', 'modified_by'
    ];

    public static function SplitAccountNumber()
    {
        //return substr("BDERP221214-1",5); //221214-1
        return substr(Auth::user()->account->account_number, 5); //221214-1
    }
    public static function totalCustomer()
    {
        $totalCustomer = Customer::where('account_id', Auth::user()->account_id)->withTrashed()->count();
        return $totalCustomer + 1;
    }

    protected static function boot()
    {
        parent::boot();

        // auto-sets account values on creation
        static::creating(function ($model) {
            $model->customer_number = "CACC" . static::SplitAccountNumber() . "-" . static::totalCustomer();
        });
    }

    //ADDRESS


    public function otherAddresses()
    {
        return $this->hasMany(Address::class, 'ref_id')->where('ref_object_key', Address::$ref_customer_key)->where('is_ship_address', 0)->where('is_bill_address', 0);
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'ref_id')->where('ref_object_key', Address::$ref_customer_key);
    }
    public function primaryContact()
    {
        return $this->hasOne(Contact::class, 'ref_id')->where('ref_object_key', Address::$ref_customer_key)->where('is_primary_contact', 1);
    }
    public function otherContacts()
    {
        return $this->hasMany(Contact::class, 'ref_id')->where('ref_object_key', Address::$ref_customer_key)->where('is_primary_contact', 0);
    }
    public function shipAddress()
    {
        return $this->hasOne(Address::class, 'ref_id')->where('ref_object_key', Address::$ref_customer_key)->where('is_ship_address', 1);
    }
    public function billAddress()
    {
        return $this->hasOne(Address::class, 'ref_id')->where('ref_object_key', Address::$ref_customer_key)->where('is_bill_address', 1);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id', 'id');
    }
}
