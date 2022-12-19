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
   
    public function update(Request $request, $user_id)
    {
      
            DB::beginTransaction();
            try {

                $user = User::find($user_id)->update(
                    [
                       // 'password'=>Hash::make($request['password']),
                        //'first_name' => $request['first_name'],
                        //'last_name' => $request['last_name'],
                        //'email' => $request['email'],
                        //'mobile' => $request['mobile'],
                        //'user_role' => $request['user_role'],
                        //'mobile_country_code' => $request['mobile_country_code'],
                        'date_of_birth' => $request['date_of_birth'],
                        'gender' => $request['gender'],
                        'language' => $request['language'],
                        'interests' => $request['interests'],
                        'occupation' => $request['occupation'],
                        'about' => $request['about'],
                        'notify_new_user' => $request['notify_new_user'],
                        'status' => $request['status'],
                        //'country' => $request['country'],
                        'created_by' => Auth::user()->id,
                        'modified_by' => Auth::user()->id,
                        'created_by' => Auth::user()->id,
                        //$request['first_name'] =$request['first_name'];
                        ]
                );
                $user=User::find($user_id);
                // $response = ['token' => $token]
                DB::commit();
                return $this->success($user);
               
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
                
            }
        
    }

    public function users(Request $request)
    {
        $this->setFilterProperty($request);
        //$accounts=Accounts::with('user')->get();
        
        $users=User::where('account_id',Auth::user()->account_id)->orderBy($this->column_name,$this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($users);
    }

    public function user($user_id){
        //return Auth::user()->account->account_id;
        $user=User::find($user_id);
        return $this->success($user);

    }
}
