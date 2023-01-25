<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\RegistrationRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    use ApiResponse, ApiFilter;

    public function register(RegistrationRequest $request){
   // return $request;
      
            DB::beginTransaction();
            try {
                $request['password']=Hash::make($request['password']);
                $request['remember_token'] = Str::random(10);
                $user = User::create($request->validated());
                // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                // $response = ['token' => $token];
                DB::commit();
                return $this->success(new UserResource($user));
               
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
