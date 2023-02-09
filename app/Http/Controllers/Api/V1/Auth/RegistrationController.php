<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\RegistrationRequest;
use App\Http\Services\V1\AccountService;
use App\Models\OldPassword;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class RegistrationController extends Controller
{
    use ApiResponse, ApiFilter;
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function register(RegistrationRequest $request)
    {

        DB::beginTransaction();
        try {
            $accountData = $this->setAccount($request);
            if (!is_int($accountData)) {
                $request['account_id'] = $accountData->id;
            } else {
                $request['account_id'] = $accountData;
            }

            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);

            $user = User::create($request->toArray());
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            $this->sendVerificationMail($user); //send verfication mail;


            if (!is_int($accountData)) {
                $updateAccount = $this->accountService->updateAccountUserId($user, $accountData);
            }
            OldPassword::create([
                'email' => $request['email'],
                'old_password' => $request['password']
            ]);
            DB::commit();
            $userWithAccount = User::with('account')->find($user->id);
            $response = [];
            $response = [
                'tokenType' => 'Bearer',
                'token' => $token,
                'user' => $userWithAccount
            ];
            return $this->success($response, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 422);
        }
    }

    public function setAccount($request)
    {
        $account = 1; //default account
        if ($request->has('company_name') && !empty($request['company_name'])) {

            $accountData['first_name'] = $request['first_name'];
            $accountData['last_name'] = $request['last_name'];
            $accountData['company_name'] = $request['company_name'];
            $newAccount = $this->accountService->store($accountData); //create new account if exsist company name
            $account = $newAccount;
        }
        return $account;
    }

    public function sendVerificationMail($user): void
    {
        event(new Registered($user));
    }
}
