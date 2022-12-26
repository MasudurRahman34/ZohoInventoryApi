<?php

namespace App\Models;

use App\Models\Location\District;
use App\Models\Location\State;
use App\Models\Location\StreetAddress;
use App\Models\Location\Thana;
use App\Models\Location\Union;
use App\Models\Location\Zipcode;
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
    
    protected $table='portal_address';
    protected $dates=[
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
 

     protected $fillable=[
            'ref_object_key','ref_id','attention','country_id','state_id','district_id','thana_id','union_id','zipcode_id','street_address_id','house','phone','fax','is_bill_address','is_ship_address','full_address','status','created_by','modified_by','account_id'
     ];

     public static function rules(){ 
     return[
        'attention'=>'required|string',
        'house' => 'required|string',
        'ref_id' => 'required|integer',
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

    public function create($item){
        
        //return $item;
        $address=new Address();
        $address->ref_object_key =$item['ref_object_key'];
        $address->ref_id =$item['ref_id'];
        $address->attention =isset($item['attention']) ? $item['attention'] : null;
        $address->country_id =isset($item['country_id']) ? $item['country_id'] : 0;
        $address->state_id =isset($item['state_id'])? $item['state_id'] : 0;
        $address->district_id =isset($item['district_id'])? $item['district_id'] : 0;
        $address->thana_id =isset($item['thana_id']) ? $item['thana_id'] : 0;
        $address->union_id =isset($item['union_id'])? $item['union_id'] : 0;
        $address->zipcode_id =isset($item['zipcode_id'])? $item['zipcode_id'] : 0;
        $address->street_address_id =isset($item['street_address_id'])? $item['street_address_id'] : 0;
        $address->house =isset($item['house'])? $item['house'] : 0;
        $address->phone =isset($item['phone'])? $item['phone'] : 0;
        $address->fax =isset($item['fax'])? $item['fax'] : 0;
        $address->is_bill_address=isset($item['is_bill_address']) ? $item['is_bill_address'] : 0;
        $address->is_ship_address=isset($item['is_ship_address']) ? $item['is_ship_address'] : 0;
        $address->status = isset($item['status']) ? $item['status'] : 0;
        $address->full_address = json_encode($this->setAddress($item));
        
        $address->save();
        return $address;
    }

    public function setAddress($request){
        $address['country']=Country::where('id',$request['country_id'])->select('id','countryName')->get();
        $address['state_id']=State::where('id',$request['state_id'])->select('id','state_name')->get();
        $address['district']=District::where('id',$request['district_id'])->select('id','district_name')->get();
        $address['thana']=Thana::where('id',$request['thana_id'])->select('id','thana_name')->get();
        $address['union']=Union::where('id',$request['union_id'])->select('id','union_name')->get();
        $address['zipcode']=Zipcode::where('id',$request['zipcode_id'])->select('id','zip_code')->get();
        $address['street_address']=StreetAddress::where('id',$request['street_address_id'])->select('id','street_address_value')->get();
        
        return $address;

    }
}
