<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiFilter, ApiResponse;

    public function update(Request $request, $uuid)
    {


        DB::beginTransaction();
        try {

            $user = User::where('uuid',$uuid)->first()->update(
                [
                    'date_of_birth' => $request['date_of_birth'],
                    'gender' => $request['gender'],
                    'language' => $request['language'],
                    'interests' => $request['interests'],
                    'occupation' => $request['occupation'],
                    'about' => $request['about'],
                    'created_by' => Auth::user()->id,
                    'modified_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id,
                ]
            );
            $user = User::find($uuid);
            // $response = ['token' => $token]
            DB::commit();
            return $this->success($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 404);
        }
    }

    public function users(Request $request)
    {
        $this->setFilterProperty($request);
        //$accounts=Accounts::with('user')->get();

        $users = User::where('account_id', Auth::user()->account_id)->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($users);
    }

    public function user($user_id)
    {
        
        //return Auth::user()->account->account_id;
        $user = User::where('uuid',$user_id)->where('account_id',Auth::user()->account_id)->first();
        if($user){
            return $this->success($user);
        }else{
            return $this->error('Data Not Found',404);
        }
       
    }
}
