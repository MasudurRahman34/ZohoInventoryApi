<?php

namespace App\Observers;
use Illuminate\Support\Facades\Auth;

class AccountObserver
{
    protected $userID;
    protected $acountId;

    public function __construct(){
        $this->userID =  Auth::user()->id;
        $this->acountId= Auth::User()->account_id;
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
