<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\RegistrationRequest;
use App\Http\Resources\v1\UserResource;
use App\Http\Services\V1\AccountService;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\ReturnTypePass;

class RegistrationController extends Controller
{
    use ApiResponse, ApiFilter;
    private $accountService;
        
    public function __construct(AccountService $accountService) {
        $this->accountService = $accountService;
    }

    public function register(RegistrationRequest $request){
       //return 'working';
   // return $request;
     // $register=$request->validated();
            DB::beginTransaction();
            try {
                $request['account_id']=1; //default account
                if ($request->has('company_name') && !empty($request['company_name'])){
                    
                    $accountData['first_name']=$request['first_name'];
                    $accountData['last_name']=$request['last_name'];
                    $accountData['company_name']=$request['company_name'];
                    $createAccount=$this->accountService->store($accountData);
                 }
                 //return $createAccount;

                 if($createAccount){
                   
                    $request['account_id']=$createAccount->id;
                 }
               
                $request['password']=Hash::make($request['password']);
                $request['remember_token'] = Str::random(10);

                $user = User::create($request->toArray());
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                
                 event(new Registered($user));

                 
                 DB::commit();
                 $user=User::with('account')->find($user->id);
                return $this->success($user,200);
               
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 422);
                
            }
      
    }

    // public function users(){

    //         $users=User::with('accounts')->get();
    //         return $this->success($users);

    // }
}
