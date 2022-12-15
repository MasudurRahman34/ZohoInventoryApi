<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;
use Illuminate\Support\Facades\Auth;

class Accounts extends Model
{
    use HasFactory,SoftDeletes,IdIncreamentable;
    protected $dates=[
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
 
     protected $fillable=[
            'account_id','account_uri','company_name','slug','compnay_logo','module_name','dashboard_blocks','language','ip_address_access','domain','host','database_name','database_user','database_password','account_super_admin','user_id','created_by','modified_by'
     ];

     public static $rules = [
        'company_name' => 'required|string|max:255',
        'module_name' => 'required|array',
    ];

    public function IdIncreamentable():array{
        return [
            'source'=>'id',
            'prefix'=>'BDERP'.date("y").date("m").date('d')."-",
            'attribute'=>'account_id',
        ];
    }
    protected static function boot()
    {
        parent::boot();

        // auto-sets account values on creation
        static::creating(function ($model) {
            $model->user_id = Auth::user()->id;
            $model->created_by = Auth::user()->id;
            $model->account_super_admin = Auth::user()->id;
        });
    }
    public function user(){
        $this->belongsTo(User::class,'user_id','id');
    }

}
