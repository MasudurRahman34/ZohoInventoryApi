<?php
namespace App\Http\Services\V1;

use App\Models\Accounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountService{


    public function store($request){
       
        $accountData = 
            [
                'account_uri' => $this->generateAccountUri($request['first_name'],$request['last_name']),
                'company_name' => $request['company_name'],
                'slug' => $this->generateSlug($request),
                'module_name' => isset($request['module_name']) ? json_encode($request['module_name']): NULL,
                'dashboard_blocks' => isset($request['dashboard_blocks']) ? $request['dashboard_blocks'] : NULL,
                'language' => isset($request['language'])? $request['language'] : NULL,
                'domain' => isset($request['domain']) ? $request['domain'] : NULL,
                'ip_address_access' => isset($request['ip_address_access']) ?$request['ip_address_access'] : NULL,
                'host' => isset($request['host']) ? $request['host']: NULL,
                'database_name' => isset($request['database_name']) ? $request['database_name']: NULL,
                'database_user' => isset($request['database_user']) ? $request['database_user']: NULL,
                'database_password' => isset($request['database_password']) ?$request['database_password'] : NULL,
            ];

        //return $accountData;
            $account= Accounts::create($accountData);
            return $account;
}
public function generateAccountUri($firstName,$lastName)
    {

        $requestedAccountUri = strtolower($firstName) . '-' . strtolower($lastName);
        

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
            ->where('slug', Str::slug($request['company_name']))
            ->get();
        if (count($checkSlug) > 0) {
            $slug = Str::slug($request['company_name']) . '-' . count($checkSlug) + 1;
        } else {
            $slug = Str::slug($request['company_name']);
        }
        return $slug;
    }

    
}
