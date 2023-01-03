<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Api\V1\Helper\IdIncreamentable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes,IdIncreamentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates=[
        'creadted_at',
        'updated_at',
        'deleted_at'
    ];
    public function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'user_number',
        'first_name',
        'last_name',
        'email',
        'password',
        'user_role',
        'mobile',
        'mobile_country_code',
        'date_of_birth',
        'gender',
        'image',
        'language',
        'interests',
        'occupation',
        'about',
        'country',
        'status',
        'remember_token',
        'notify_new_user',
        'created_by',
        'created_at',
        'updated_at',
        'modified_by',
        'account_id',
        'branch_id',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function rules() { 
        return [
        'first_name' => ['required','string','max:255'],
        'last_name' => ['required','string','max:255'],
        'email' => ['required','string','email','max:255','unique:users'],
        'mobile' => ['required','integer','max:11','unique:users'],
        'country' => ['required','string'],
        'mobile_country_code' => ['required','string','max:3'],
        'notify_new_user'=>['in:0,1'],
        'status'=>['in:0,1,2,3'],
        'password' => ['required','confirmed', Password::min(8)
        ->letters()
        ->mixedCase()
        ->numbers()
        ->symbols()
        ->uncompromised()
                                                   
                    
                        ]
        ];
    }

    public static $login_rules = [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6',
    ];

    public function IdIncreamentable():array{
        return [
            'source'=>'id',
            'prefix'=>'BE'.date("y").date("m").date('d'),
            'attribute'=>'user_number',
        ];
    }

    public function account(){
       return $this->belongsTo(Accounts::class,'account_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     // auto-sets account values on creation
    //     static::creating(function ($model) {
    //         // $model->account_id = Auth::user()->id;
    //         $model->created_by = Auth::user()->id;
           
    //     });
    // }
}
