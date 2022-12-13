<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Helper\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    use ApiResponse;

    public function register(Request $request){
   // return $request;
        $validator= Validator::make($request->all(), User::$rules);
        if ($validator->fails()) {
            return $this->error($validator->errors(),200);
        }else{
            DB::beginTransaction();
            try {
                $request['password']=Hash::make($request['password']);
                $request['remember_token'] = Str::random(10);
                //$request['first_name'] =$request['first_name'];
                $user = User::create($request->toArray());
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                DB::commit();
                return response($response, 200);
               
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 500);
                
            }
      }
    }
}
