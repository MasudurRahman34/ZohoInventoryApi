<?php

namespace App\Rules\V1;

use App\Models\OldPassword;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MatchOldPassword implements DataAwareRule, InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    protected $data = [];
    protected $validator;
    public function __invoke($attribute, $value, $fail)
    {
        // if ($this->data['password'] == $this->data['email']) {
        //     $fail('does not match');
        // }
        $old_password_token = session()->has('old_password_token') ? session('old_password_token') : null;
        $payload_password_token = isset($this->data['old_password_token']) ? $this->data['old_password_token'] : 0;
        if ($old_password_token !=  $payload_password_token) {
            $checkExist = OldPassword::where('email', $this->data['email'])->orderBy('id', 'desc')->get();
            if (count($checkExist) > 0) {
                foreach ($checkExist as $key => $value) {
                    Session::put('old_password_token', rand(0, 99999));
                    if (Hash::check($this->data['password'], $value['old_password'])) {

                        $fail('Given Old Password ! You had Changed It ' . Carbon::parse($value['created_at'])->diffForHumans() . '.' . ' Would You like to keep it ?');
                    }
                }
            }
        }
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
