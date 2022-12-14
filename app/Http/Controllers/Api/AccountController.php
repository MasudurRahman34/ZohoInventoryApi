<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Helper\ApiFilter;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\Helper\ApiResponse;
use App\Models\User;

class AccountController extends Controller
{
    use ApiResponse, ApiFilter;
    public function updateOrCreate(Request $request, $account_id=''){
        //return $request;
        $validator= Validator::make($request->all(), Accounts::$rules);
        if ($validator->fails()) {
            return $this->error($validator->errors(),200);
        }else{
            DB::beginTransaction();
            try {
                $account = Accounts::updateOrCreate(
                    ['id' => $account_id],
                    [
                        'account_uri' => $this->generateAccountUri(),
                        'company_name' => $request['company_name'],
                        'slug' =>$this->generateSlug($request),
                        'module_name' => json_encode($request['module_name']),
                        'dashboard_blocks' => @$request['dashboard_blocks'],
                        'language' => $request['language'],
                        'domain' => $request['domain'],
                        'ip_address_access' => $request['ip_address_access'],
                        'host' => $request['host'],
                        'database_name' => $request['database_name'],
                        'database_user' => $request['database_user'],
                        'database_password' => $request['database_password'],
                        'modified_by' => Auth::user()->id,
                    ]
                );
                $updateUserAccount=User::Find(Auth::user()->id)->update(['account_id'=>$account->id]);
                DB::commit();
                return $this->success($account);
               
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->error($e->getMessage(), 200);
                
            }
      }
    }

    public function generateAccountUri(){
        $checkAccountUri = DB::table('accounts')
                            ->select('account_uri')
                            ->where('account_uri',Auth::user()->first_name.'-'.Auth::user()->last_name)
                            ->get();

            // return $checkAccountUri;
            if (count($checkAccountUri)>0){
                $account_uri=Auth::user()->first_name.'-'.Auth::user()->last_name.'-'.count($checkAccountUri)+1;
                }else{
                    $account_uri= Auth::user()->first_name.'-'.Auth::user()->last_name;
                }
                return $account_uri;
    }

    public function generateSlug($request){
        $checkSlug = DB::table('accounts')
                            ->select('slug')
                            ->where('slug',Str::slug($request->company_name))
                            ->get();
                if (count($checkSlug)>0){
                    $slug=Str::slug($request->company_name).'-'.count($checkSlug)+1;
                    }
                else{
                        $slug= Str::slug($request->company_name);
                    }
                return $slug;
    }

    public function accounts(Request $request){
        $this->setFilterProperty($request);
        //$accounts=Accounts::with('user')->get();
        
        $accounts=Accounts::orderBy($this->column_name,$this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($accounts);
    }

}
