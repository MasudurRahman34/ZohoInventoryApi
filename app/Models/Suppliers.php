<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Suppliers extends Model
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
            'supplier_id','contactId','supplier_type','display_name','company_name','website','tax_rate','currency','image','payment_terms','account_id','created_by','modified_by'
     ];

     public static $rules = [
        'display_name' => 'required|string|max:100',
       // 'company_name' => 'required|string|max:255',
    ];

    public static function SplitAccountNumber(){
        //return substr("BDERP221214-1",5); //221214-1
        return substr(Auth::user()->account->account_id,5); //221214-1
     }
     public static function totalSupplier(){
         $totalSupplier= Suppliers::where('account_id',Auth::user()->account_id)->count();
         return $totalSupplier+1;
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
            $model->supplier_number="SACC".static::SplitAccountNumber().static::totalSupplier();
            $model->created_by = Auth::user()->id;
            $model->account_id = Auth::user()->id;
        });
    }
}
