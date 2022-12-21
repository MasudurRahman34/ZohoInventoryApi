<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use DateTimeInterface;
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
            'ref_object_key','ref_id','salutation','first_name','last_name','display_name','company_name','contact_work_phone','contact_mobile',
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

}
