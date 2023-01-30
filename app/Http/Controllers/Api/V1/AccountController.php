<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\AccountRequest;
use App\Http\Requests\v1\BusinessTypeRequest;
use App\Http\Services\V1\AccountService;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

class AccountController extends Controller
{
    use ApiResponse, ApiFilter;

    private $accountService;
    public function __construct(AccountService $accountService = null)
    {
        $this->accountService = $accountService;
    }

    // public function store(Request $request, $account_id = '')
    // {
    //     //return $request;
    //     $validator = Validator::make($request->all(), Accounts::$rules);
    //     if ($validator->fails()) {
    //         return $this->error($validator->errors(), 200);
    //     } else {
    //         DB::beginTransaction();
    //         try {
    //             $account = Accounts::updateOrCreate(
    //                 ['id' => $account_id],
    //                 [
    //                     'account_uri' => $this->generateAccountUri(),
    //                     'company_name' => $request['company_name'],
    //                     'slug' => $this->generateSlug($request),
    //                     'module_name' => json_encode($request['module_name']),
    //                     'dashboard_blocks' => @$request['dashboard_blocks'],
    //                     'language' => $request['language'],
    //                     'domain' => $request['domain'],
    //                     'ip_address_access' => $request['ip_address_access'],
    //                     'host' => $request['host'],
    //                     'database_name' => $request['database_name'],
    //                     'database_user' => $request['database_user'],
    //                     'database_password' => $request['database_password'],
    //                     'modified_by' => Auth::user()->id,
    //                 ]
    //             );
    //             $updateUserAccount = User::Find(Auth::user()->id)->update(['account_id' => $account->id]);
    //             DB::commit();
    //             return $this->success($account);
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             return $this->error($e->getMessage(), 200);
    //         }
    //     }
    // }

    public function update(AccountRequest $request, $uuid)
    {

        $account = Accounts::where('uuid', $uuid)->where('user_id', Auth::user()->id)->first();

        if ($account) {

            try {
                DB::beginTransaction();

                $updatedAccount = $this->accountService->update($request, $account);
                //return $updatedAccount;
                DB::commit();
                return $this->success($account);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error("Data Not Found", 404);
        }
    }

    public function updateUserAccount(AccountRequest $request, $uuid)
    {
        $account = Accounts::where('uuid', $uuid)->where('user_id', Auth::user()->id)->first();

        if ($account) {

            try {

                $updatedAccount = $this->accountService->update($request, $account);
                //return $updatedAccount;
                return $this->success($account);
            } catch (\Throwable $th) {
                return $this->error($th->getMessage(), 422);
            }
        } else {
            return $this->error("Data Not Found", 404);
        }
        //return $request['business_type_parent_id'];
    }

    public function store(AccountRequest $request)
    {
        // return Auth::user()->id;
        if (Auth::user()->account_id == 1) {
            try {
                DB::beginTransaction();
                $newAccount = $this->accountService->store($request);
                if ($newAccount) {
                    $updateUserAccount = User::Find(Auth::user()->id)->update(['account_id' => $newAccount->id]);
                }
                DB::commit();
                $updatedUserAccount = User::with('account')->find(Auth::user()->id);
                return $this->success($updatedUserAccount);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->error($th->getMessage(), 422);
            }
        }
        return $this->error('Your Account Already Exist !', 406);
    }




    public function generateAccountUri()
    {

        $requestedAccountUri = strtolower(Auth::user()->first_name) . '-' . strtolower(Auth::user()->last_name);

        $checkAccountUri = DB::table('accounts')
            ->select('account_uri')
            ->where('account_uri', $requestedAccountUri)
            ->get();

        if (count($checkAccountUri) > 0) {
            $accountUri = $requestedAccountUri . '-' . count($checkAccountUri) + 1;
        } else {
            $accountUri = $requestedAccountUri;
        }
        return $accountUri;
    }

    public function generateSlug($request)
    {
        $checkSlug = DB::table('accounts')
            ->select('slug')
            ->where('slug', Str::slug($request->company_name))
            ->get();
        if (count($checkSlug) > 0) {
            $slug = Str::slug($request->company_name) . '-' . count($checkSlug) + 1;
        } else {
            $slug = Str::slug($request->company_name);
        }
        return $slug;
    }

    public function accounts(Request $request)
    {
        $this->setFilterProperty($request);
        //$accounts=Accounts::with('user')->get();

        $accounts = Accounts::orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($accounts);
    }
}
