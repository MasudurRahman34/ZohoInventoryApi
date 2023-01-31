<?php

namespace App\Http\Services\V1;

use App\Models\Accounts;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountService
{


    public function store($request)
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
        } else {
            // $userId = User::nextId(); deost work thats why need to update while registration
            $userId = 1;
        }

        $accountData =
            [
                'account_uri' => $this->generateAccountUri($request['first_name'], $request['last_name']),
                'company_name' => $request['company_name'],
                'slug' => $this->generateSlug($request),
                'module_name' => isset($request['module_name']) ? json_encode($request['module_name']) : NULL,
                'dashboard_blocks' => isset($request['dashboard_blocks']) ? $request['dashboard_blocks'] : NULL,
                'language' => isset($request['language']) ? $request['language'] : NULL,
                'domain' => isset($request['domain']) ? $request['domain'] : NULL,
                'ip_address_access' => isset($request['ip_address_access']) ? $request['ip_address_access'] : NULL,
                'host' => isset($request['host']) ? $request['host'] : NULL,
                'database_name' => isset($request['database_name']) ? $request['database_name'] : NULL,
                'database_user' => isset($request['database_user']) ? $request['database_user'] : NULL,
                'database_password' => isset($request['database_password']) ? $request['database_password'] : NULL,
                'account_super_admin' => isset($request['account_super_admin']) ? $request['account_super_admin'] : 0,
                'user_id' => $userId,

            ];

        //return $accountData;
        $newAccount = Accounts::create($accountData);
        if (isset($request['business_type_id'])) {

            $this->storeAccountBusinessType($request['business_type_id'], $newAccount);
        }
        return $newAccount;
    }

    public function update($request, $account)
    {
        // return $request['business_type_parent_id'];
        if ((isset($request['first_name'])) && isset(($request['last_name']))) {
            $accountUri = $this->generateAccountUri($request['first_name'], $request['last_name']);
        } else {
            $accountUri = $account->account_uri;
        };
        if (isset($request['company_name'])) {
            $slug = $this->generateSlug($request);
        } else {
            $slug = $account->slug;
        }

        $accountData =
            [
                'account_uri' => $accountUri,
                'company_name' => isset($request['company_name']) ? $request['company_name'] : $account->company_name,
                'slug' =>  $slug,
                'module_name' => isset($request['module_name']) ? $request['module_name'] : $account->module_name,
                'dashboard_blocks' => isset($request['dashboard_blocks']) ? $request['dashboard_blocks'] : $account->dashboard_blocks,
                'language' => isset($request['language']) ? $request['language'] : $account->language,
                'domain' => isset($request['domain']) ? $request['domain'] : $account->domain,
                'ip_address_access' => isset($request['ip_address_access']) ? $request['ip_address_access'] : $account->ip_address_access,
                'host' => isset($request['host']) ? $request['host'] : $account->host,
                'database_name' => isset($request['database_name']) ? $request['database_name'] : $account->database_name,
                'database_user' => isset($request['database_user']) ? $request['database_user'] : $account->database_user,
                'database_password' => isset($request['database_password']) ? $request['database_password'] : $account->database_password,
                'account_super_admin' => isset($request['account_super_admin']) ? $request['account_super_admin'] : $account->account_super_admin,
                'modified_by' => Auth::user()->id,
                'user_id' => Auth::user()->id,
            ];
        //return $accountData;
        $updatedAccount =  $account->update($accountData);

        return $updatedAccount;
    }

    public function updateAccountUserId($user, $account)
    {
        $userData = [
            'user_id' => $user->id
        ];
        $updateAccount = $account->update($userData);
        return $updateAccount;
    }



    public function generateAccountUri($firstName, $lastName)
    {

        $requestedAccountUri = strtolower($firstName) . '-' . strtolower($lastName);


        $checkAccountUri = DB::table('accounts')
            ->select('account_uri')
            ->where('account_uri', 'LIKE', $requestedAccountUri . '%')
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
            ->where('slug', 'LIKE', Str::slug($request['company_name']) . '%')
            ->get();
        if (count($checkSlug) > 0) {
            $slug = Str::slug($request['company_name']) . '-' . count($checkSlug) + 1;
        } else {
            $slug = Str::slug($request['company_name']);
        }
        return $slug;
    }
    public function storeAccountBusinessType($business_type_ids, $account)
    {
        if (count($business_type_ids) > 0) {
            # code...
            $business_type = [];
            foreach ($business_type_ids as $key => $business_type_id) {

                $business_type[$key] = [
                    'business_type_id' => $business_type_id
                ];
            }


            $newAccountBusinessType = $account->businessTypes()->attach($business_type);
            return $newAccountBusinessType;
        }
    }
}
