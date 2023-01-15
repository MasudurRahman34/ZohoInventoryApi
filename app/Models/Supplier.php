<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;
use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use App\Models\Scopes\AccountScope;
use App\Models\Scopes\ScopeUuid;
use App\Observers\LogObserver;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Supplier extends Model
{

    use HasFactory,SoftDeletes,AccountObservant, HasUuids,ScopeUuid;
    protected $table='portal_suppliers';
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
            'supplier_number','uuid','supplier_type','display_name','copy_bill_address','company_name','website','tax_rate','tax_name','currency','image','payment_terms','account_id','created_by','modified_by'
     ];

    //  public static $rules = [
    //     'display_name' => 'required|string|max:100',
    //    // 'company_name' => 'required|string|max:255',
    // ];

    public static function SplitAccountNumber(){
        //return substr("BDERP221214-1",5); //221214-1
        return substr(Auth::user()->account->account_number,5); //221214-1
     }
     public static function totalSupplier(){
         $totalSupplier= Supplier::where('account_id',Auth::user()->account_id)->withTrashed()->count();
         return $totalSupplier+1;
     }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->supplier_number="SACC".static::SplitAccountNumber()."-".static::totalSupplier();
        });
    }

    //ADDRESS
   

    public function otherAddresses(){
        return $this->hasMany(Address::class,'ref_id')->where('ref_object_key',Address::$ref_supplier_key)->where('is_ship_address',0)->where('is_bill_address',0);
    }

    public function contacts(){
        return $this->hasMany(Contact::class,'ref_id')->where('ref_object_key',Address::$ref_supplier_key);
    }
    public function primaryContact(){
        return $this->hasOne(Contact::class,'ref_id')->where('ref_object_key',Address::$ref_supplier_key)->where('is_primary_contact',1);
    }
    public function otherContacts(){
        return $this->hasMany(Contact::class,'ref_id')->where('ref_object_key',Address::$ref_supplier_key)->where('is_primary_contact',0);
    }
    public function shipAddress(){
        return $this->hasOne(Address::class,'ref_id')->where('ref_object_key',Address::$ref_supplier_key)->where('is_ship_address',1);
    }
    public function billAddress(){
        return $this->hasOne(Address::class,'ref_id')->where('ref_object_key',Address::$ref_supplier_key)->where('is_bill_address',1);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class,'supplier_id','id');
    }

}
  