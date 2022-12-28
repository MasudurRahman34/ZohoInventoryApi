<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{

    use HasFactory,SoftDeletes;

    protected $table='portal_customers';
    protected $hidden = [
        'account_id'
    ];
    protected $dates=[
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    

    
    public function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
 
     protected $fillable=[
            'customer_number','copy_bill_address','customer_type','display_name','company_name','website','tax_name','tax_rate','currency','image','payment_terms','account_id','created_by','modified_by'
     ];

     public static $rules = [
        'display_name' => 'required|string|max:100',
       // 'company_name' => 'required|string|max:255',
    ];

    public static function SplitAccountNumber(){
        //return substr("BDERP221214-1",5); //221214-1
        return substr(Auth::user()->account->account_number,5); //221214-1
     }
     public static function totalCustomer(){
         $totalCustomer= Customer::where('account_id',Auth::user()->account_id)->withTrashed()->count();
         return $totalCustomer+1;
     }

    // public function IdIncreamentable():array{
    //     return [
    //         'source'=>'id',
    //         'prefix'=>'SACC'.date("y").date("m").date('d')."-",
    //         'attribute'=>'account_id',
    //     ];
    // }

    
    protected static function boot()
    {
        parent::boot();

        // auto-sets account values on creation
        static::creating(function ($model) {
            $model->customer_number="CACC".static::SplitAccountNumber()."-".static::totalCustomer();
            $model->created_by = Auth::user()->id;
            $model->account_id = Auth::user()->account_id;
        });
    }

    //ADDRESS
   

    public function otherAddresses(){
        return $this->hasMany(Address::class,'ref_id')->where('ref_object_key',Address::$ref_customer_key)->where('is_ship_address',0)->where('is_bill_address',0);
    }
    public function contacts(){
        return $this->hasMany(Contact::class,'ref_id')->where('ref_object_key',Address::$ref_customer_key);
    }
    public function primaryContact(){
        return $this->hasOne(Contact::class,'ref_id')->where('ref_object_key',Address::$ref_customer_key)->where('is_primary_contact',1);
    }
    public function otherContacts(){
        return $this->hasMany(Contact::class,'ref_id')->where('ref_object_key',Address::$ref_customer_key)->where('is_primary_contact',0);
    }
    public function shipAddress(){
        return $this->hasOne(Address::class,'ref_id')->where('ref_object_key',Address::$ref_customer_key)->where('is_ship_address',1);
    }
    public function billAddress(){
        return $this->hasOne(Address::class,'ref_id')->where('ref_object_key',Address::$ref_customer_key)->where('is_bill_address',1);
    }
}
