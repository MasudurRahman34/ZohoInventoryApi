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
    use HasFactory, SoftDeletes;

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

    public static function rules()
    {
        return [
            'attention' => 'required|string',
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

    public function store($item)
    {
        //return $item;
        $globalAddresess = GlobalAddress::get();

        
        //return  $globalAddresess;
        $address = new Address();
        $address->ref_object_key = $item['ref_object_key'];
        $address->ref_id = $item['ref_id'];
        $address->attention = isset($item['attention']) ? $item['attention'] : null;
        $address->country_id = isset($item['country_id']) ? $item['country_id'] : 0;
        $address->state_id = isset($item['state_id']) ? $item['state_id'] : 0;
        $address->district_id = isset($item['district_id']) ? $item['district_id'] : 0;
        $address->thana_id = isset($item['thana_id']) ? $item['thana_id'] : 0;
        $address->union_id = isset($item['union_id']) ? $item['union_id'] : 0;
        $address->zipcode_id = isset($item['zipcode_id']) ? $item['zipcode_id'] : 0;
        $address->street_address_id = isset($item['street_address_id']) ? $item['street_address_id'] : 0;
        $address->house = isset($item['house']) ? $item['house'] : 0;
        $address->phone = isset($item['phone']) ? $item['phone'] : 0;
        $address->fax = isset($item['fax']) ? $item['fax'] : 0;
        $address->is_bill_address = isset($item['is_bill_address']) ? $item['is_bill_address'] : 0;
        $address->is_ship_address = isset($item['is_ship_address']) ? $item['is_ship_address'] : 0;
        $address->status = isset($item['status']) ? $item['status'] : 0;
        $address->full_address = $this->setAddress($item);
        $address->save();

        //insert global address
        $is_find_global_address=FALSE;
        if (count($globalAddresess) == 0) { //first insert
                $globalAddresess = GlobalAddress::get();
                foreach ($globalAddresess as $key => $value) {
                    if ($value->full_address != $address->full_address) {
                            $is_find_global_address=FALSE;
                    }else{
                        return $is_find_global_address=TRUE;
                    }
                }
        } else {

            foreach ($globalAddresess as $key => $value) {
                if ($value->full_address != $address->full_address) {
                        $is_find_global_address=FALSE;
                }else{
                    $is_find_global_address=TRUE;
                    return $address;
                }
            }
        };
    //    if($is_find_global_address==TRUE){
    //     return $address;
    //    }
        //if $is_find_global_address=false then insert 
        if($is_find_global_address==FALSE){
            $globalAddress = new GlobalAddress();
            $globalAddress->country_id = $address->country_id;
            $globalAddress->state_id = $address->state_id;
            $globalAddress->district_id = $address->district_id;
            $globalAddress->thana_id = $address->thana_id;
            $globalAddress->union_id = $address->union_id;
            $globalAddress->zipcode_id = $address->zipcode_id;
            $globalAddress->street_address_id = $address->street_address_id;
            $globalAddress->full_address = $address->full_address;
            $globalAddress->plain_address = $this->setPlainAddress($address->full_address);
            $globalAddress->status = 1;
            $globalAddress->save();
        }

        return $address;
    }

    public function setAddress($request)
    {
        //$add=Country::where('id',$request['country_id'])->select('id','countryName')->get();
        //return print_r($add);
        $address['country'] = Country::where('id', $request['country_id'])->select('id', 'countryName')->first();
        $address['state_id'] = State::where('id', $request['state_id'])->select('id', 'state_name')->first();
        $address['district'] = District::where('id', $request['district_id'])->select('id', 'district_name')->first();
        $address['thana'] = Thana::where('id', $request['thana_id'])->select('id', 'thana_name')->first();
        $address['union'] = Union::where('id', $request['union_id'])->select('id', 'union_name')->first();
        $address['zipcode'] = Zipcode::where('id', $request['zipcode_id'])->select('id', 'zip_code')->first();
        $address['street_address'] = StreetAddress::where('id', $request['street_address_id'])->select('id', 'street_address_value')->first();
        //dd($address);
        return $address;
    }

    public function storeGlobalAddress($address){

    }

    public function setPlainAddress($fullAddress){
        $plainAddress=$fullAddress['street_address']['street_address_value'].'-'.$fullAddress['zipcode']['zip_code'].', '.$fullAddress['union']['union_name'].', '.$fullAddress['thana']['thana_name'].', '.$fullAddress['district']['district_name'].', '.$fullAddress['country']['countryName'] ;
       return  $plainAddress;

    }
}
