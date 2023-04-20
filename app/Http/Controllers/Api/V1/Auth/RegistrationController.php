<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Accounts;
use App\Models\Warehouse;
use App\Models\Permission;
use App\Models\UserInvite;
use App\Models\OldPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AccountPermission;
use Illuminate\Support\Facades\DB;
use App\Models\Scopes\AccountScope;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Services\V1\AccountService;

use Illuminate\Support\Facades\Response;
use App\Http\Requests\v1\RegistrationRequest;
use Illuminate\Http\Response as HttpResponse;
use App\Notifications\V1\InviteUserRegistration;
use App\Http\Controllers\Api\V1\Helper\ApiFilter;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Requests\v1\RegisterByInvitationRequest;

class RegistrationController extends Controller
{
    use ApiResponse, ApiFilter;
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function register(Request $request)
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

            if($request['account_id'] > 1){
                $role = DB::table('roles')->where('name', 'Admin')->where('default', 'yes')->where('status', 'active')->first();
                if ($role) {
                    DB::table('model_has_roles')->insert(['role_id' => $role->id, 'model_type' => User::class, 'model_id' => $user->id]);
                    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
                }
                $user->update(['user_role'=>'Admin']);

            }

            DB::commit();
            $userWithAccount = User::with('account')->find($user->id);
            $response = [];
            $response = [
                'tokenType' => 'Bearer',
                'token' => $token,
                'user' => $userWithAccount
            ];
            return $this->success($response);
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
            if ($newAccount) {
                $this->createWarehouse($newAccount->company_name, $newAccount->id);
                $this->createAccountPermission($newAccount->id);
            }
        }
        return $account;
    }

    public function sendVerificationMail($user): void
    {
        event(new Registered($user));
    }

    public function createWarehouse($name, $account_id)
    {
        $checkexsistSlug = DB::table('warehouses')
            ->select('slug')
            ->where('slug', 'LIKE', Str::slug($name) . '%')
            ->get();
        if (count($checkexsistSlug) > 0) {
            $slug = Str::slug($name) . '-' . count($checkexsistSlug) + 1;
        } else {
            $slug = Str::slug($name);
        }
        Warehouse::create(['name' => $name, 'slug' => $slug, 'account_id' => $account_id, 'default' => 'true']);
    }

    public function createAccountPermission($accountId){

            $permission = Permission::selectRaw('id as permission_id, title, description, status, ? as account_id', [$accountId])
            ->get()
            ->toArray();
            $accountPermission= AccountPermission::insert($permission);
    }

    public function registerByInvitation(RegisterByInvitationRequest $request)
    {
        try {
            DB::beginTransaction();
            $registerRequest = $request->validated();

            $findInvitation = DB::table('user_invites')->where('token', $registerRequest['token'])->where('email', $registerRequest['email'])->first();
            if ($findInvitation) {
                $registerRequest['first_name'] = $findInvitation->first_name;
                $registerRequest['user_role'] = $findInvitation->role;
                $registerRequest['email_verified_at'] = \now();
                $registerRequest['account_id'] = $findInvitation->account_id;
                $registerRequest['password'] = Hash::make($registerRequest['password']);
                $registerRequest['remember_token'] = Str::random(10);
                $user = User::create($registerRequest);
                $role = DB::table('roles')->where('account_id', $findInvitation->account_id)->where('name', $findInvitation->role)->first();
                if (!$role) {
                    return $this->error('There Is No Role', HttpResponse::HTTP_FORBIDDEN);
                }
                DB::table('model_has_roles')->insert(['role_id' => $role->id, 'model_type' => User::class, 'model_id' => $user->id]);
                app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

                $authToken = $user->createToken('Laravel Password Grant Client')->accessToken;

                OldPassword::create([
                    'email' => $user->email,
                    'old_password' => $user->password
                ]);
                DB::table('user_invites')->where('id', $findInvitation->id)->update(['registared_at' => now(), 'status' => 'accepted']);
                DB::commit();
                $userWithAccount = User::with('account')->find($user->id);
                $response = [];

                $response = [
                    'tokenType' => 'Bearer',
                    'token' => $authToken,
                    'user' => $userWithAccount
                ];
                return $this->success($response);
            } else {
                return $this->error('Invalid Invitation', HttpResponse::HTTP_FORBIDDEN);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->error($th->getMessage(), 500);
        }
    }
}
