<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes;

    public static $ref_supplier_key="App\Models\Suppliers";
    public static $ref_customer_key="App\Models\Customers";
    public static $ref_user_key="App\Models\Users";
    
    protected $table='lara_portal_address';
    protected $dates=[
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
 

     protected $fillable=[
            'ref_object_key','ref_id','attention','country_id','state_id','district_id','thana_id','union_id','zipcode_id','street_address_id','house','phone','fax','is_bill_address','is_ship_address','address','created_by','modified_by','account_id'
     ];

     public static function rules(){ 
     return[
        'attention'=>'required|string',
        'house' => 'required|string',
        'ref_id' => 'required|integer',
        'country_id' => 'required|integer',
        'state_id' => 'required|integer',
        'district_id' => 'required|integer',
        'thana_id' => 'required|integer',
        'union_id' => 'required|integer',
        'zipcode_id' => 'required|integer',
        'street_address_id' => 'required|integer',
       // 'company_name' => 'required|string|max:255',
    ];
}

    
    protected static function boot()
    {
        parent::boot();

        // auto-sets account values on creation
        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->account_id = Auth::user()->account_id;
        });
    }
}
