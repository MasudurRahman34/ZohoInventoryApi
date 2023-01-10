<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\AccountObservant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use DateTimeInterface;
use GuzzleHttp\Psr7\Request;

class Contact extends Model
{
    use HasFactory,SoftDeletes,AccountObservant;
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
            'ref_object_key','ref_id','salutation','first_name','last_name','display_name','company_name','contact_work_phone','phone_number_country_code','contact_mobile','contact_email',
            'skype','facebook','twitter','designation','department','website','is_primary_contact','contact_type_id',
            'account_id','created_by','modified_by'
     ];

}
