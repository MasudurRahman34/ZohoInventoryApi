<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use DateTimeInterface;
use GuzzleHttp\Psr7\Request;

class Contact extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates=[
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];

    public function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
 
     protected $fillable=[
            'ref_object_key','ref_id','salutation','first_name','last_name','display_name','company_name','contact_work_phone','phone_number_country_code','contact_mobile',
            'skype','facebook','twitter','designation','department','website','is_primary_contact','contact_type_id',
            'account_id','created_by','modified_by'
     ];

     public static $rules = [
        'ref_object_key' => 'required|string|max:100',
        'ref_id' => 'required|integer',
       // 'company_name' => 'required|string|max:255',
    ];

    protected static function boot()
    {
        parent::boot();

        // auto-sets account values on creation
        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->account_id = Auth::user()->account_id;
        });
    }

    public function create($item, $ref_id,$ref_object_key){
            $contact=new Contact();
            $contact->ref_object_key =$ref_object_key;
            // $contact->ref_id =$customer->id;
            $contact->ref_id =$ref_id;
            $contact->salutation =isset($item['salutation']) ?$item['salutation'] : null;
            $contact->first_name =isset($item['first_name']) ? $item['first_name'] : null;
            $contact->last_name =isset($item['last_name'])? $item['last_name'] : null;
            $contact->display_name =isset($item['display_name'])? $item['display_name'] : '';
            $contact->company_name =isset($item['company_name']) ? $item['company_name'] : null;
            $contact->contact_email =isset($item['contact_email'])? $item['contact_email'] : null;
            $contact->contact_work_phone =isset($item['contact_work_phone'])? $item['contact_work_phone'] : null;
            $contact->phone_number_country_code =isset($item['phone_number_country_code']) ? $item['phone_number_country_code'] : null;
            $contact->contact_mobile = isset($item['contact_mobile']) ? $item['contact_mobile'] : null;
            $contact->skype = isset($item['skype']) ? $item['skype'] : null;
            $contact->facebook = isset($item['facebook']) ? $item['facebook'] : null;
            $contact->twitter = isset($item['twitter']) ? $item['twitter'] : null;
            $contact->website = isset($item['website']) ? $item['website'] : null;
            
            $contact->designation = isset($item['designation']) ? $item['designation'] : null;
            $contact->department = isset( $item['department']) ? $item['department'] : null;
            $contact->is_primary_contact = isset($item['is_primary_contact']) ? $item['is_primary_contact']:0;
            $contact->contact_type_id = isset($item['contact_type_id']) ? $item['contact_type_id']:0;
            $contact->save();
            return $contact;
    }

}
