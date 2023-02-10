<?php

namespace App\Http\Services\V1;

use App\Models\Accounts;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    private $accountService;
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }




    public function update($request, $user)
    {
        // return $request['business_type_parent_id'];
        if ((isset($request['first_name'])) && isset(($request['last_name']))) {
            $hasUserAccount = Accounts::where('id', $user->id)->first();
            if ($hasUserAccount) {
                $this->accountService->update($request, $hasUserAccount);
            }
        }


        $updateData =
            [

                'first_name' => isset($request['first_name']) ? $request['first_name'] : $user->first_name,
                'last_name' => isset($request['last_name']) ? $request['last_name'] : $user->last_name,
                'user_role' => isset($request['user_role']) ? $request['user_role'] : $user->user_role,
                'mobile' => isset($request['mobile']) ? $request['mobile'] : $user->mobile,
                'country' => isset($request['country']) ? $request['country'] : $user->country,
                'mobile_country_code' => isset($request['mobile_country_code']) ? $request['mobile_country_code'] : $user->mobile_country_code,
                'notify_new_user' => isset($request['notify_new_user']) ? $request['notify_new_user'] : $user->notify_new_user,

                'country_code' => isset($request['country_code']) ? $request['country_code'] : $user->country_code,
                'status' => isset($request['status']) ? $request['status'] : $user->status,
                'date_of_birth' => isset($request['date_of_birth']) ? $request['date_of_birth'] : $user->date_of_birth,
                'gender' => isset($request['gender']) ? $request['gender'] : $user->gender,
                'ip_address_access' => isset($request['ip_address_access']) ? $request['ip_address_access'] : $user->ip_address_access,
                'language' => isset($request['language']) ? $request['language'] : $user->language,
                'about' => isset($request['about']) ? $request['about'] : $user->about,
                'occupation' => isset($request['occupation']) ? $request['occupation'] : $user->occupation,
                'is_skip_businesstype_section' => isset($request['is_skip_businesstype_section']) ? $request['is_skip_businesstype_section'] : $user->is_skip_businesstype_section,
                'modified_by' => Auth::user()->id,
            ];
        //return $accountData;
        $updateUser =  $user->update($updateData);

        return $updateUser;
    }
}
