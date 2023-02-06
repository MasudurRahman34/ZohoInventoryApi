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
use App\Http\Requests\v1\AccountBusinessTypeRequest;
use App\Http\Requests\v1\AccountRequest;
use App\Http\Requests\v1\BusinessTypeRequest;
use App\Http\Services\V1\AccountService;
use App\Models\AccountBusinessType;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

class AccountController extends Controller
{
    use ApiResponse, ApiFilter;

    private $accountService;
    public function __construct(AccountService $accountService = null)
    {
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
        $this->setFilterProperty($request);
        //$accounts=Accounts::with('user')->get();

        $accounts = Accounts::with('businessTypes')->orderBy($this->column_name, $this->sort)->paginate($this->show_per_page)->withQueryString();
        return $this->success($accounts);
    }


    public function store(AccountRequest $request)
    {
        // return $request['business_type_id'][0];
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

    //if account already exist;
    public function storeAccountBusinessType(AccountBusinessTypeRequest $request, $accountUuid)
    {

        $account = Accounts::with('businessTypes')->where('user_id', Auth::user()->id)->where('uuid', $accountUuid)->first();

        if ($account) {
            foreach ($request['business_type_id'] as $busessTypeId) {
                $hasAccountbusinessType = AccountBusinessType::where('business_type_id', $busessTypeId)->where('accounts_id', $account->id)->first();
                if ($hasAccountbusinessType) {
                    return $this->error([
                        'accountBusinessType' => ['Account Business Type Already Exist']
                    ], 422);
                }
            }

            try {
                $newAccountBusinessType = $this->accountService->storeAccountBusinessType($request['business_type_id'], $account);
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
}
