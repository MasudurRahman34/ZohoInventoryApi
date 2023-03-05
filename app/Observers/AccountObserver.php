<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class AccountObserver
{
    protected $userID;
    protected $acountId;

    public function __construct()
    {
        $this->userID =  Auth::guard('api')->check() ? (Auth::guard('api')->user()->id != null ? Auth::guard('api')->user()->id : 0) : 0;
        $this->acountId = Auth::guard('api')->check() ? (Auth::guard('api')->user()->account_id != null ? Auth::guard('api')->user()->account_id : 1)  : 1;
    }


    public function updating($model)
    {
        $model->modified_by = $this->userID;
    }


    public function creating($model)
    {
        $model->created_by = $this->userID;
        $model->account_id = $this->acountId;
        //$model->modified_by = $this->userID;
    }


    // public function removing($model)
    // {
    //     $model->purged_by = $this->userID;
    // }


}
