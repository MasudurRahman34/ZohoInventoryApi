<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\NewPasswordResetRequest;
use App\Models\OldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    use ApiResponse;


    public function create(Request $request)
    {
        return  $link = [
            'email' => $request->email,
            'token' => $request->route('token')
        ];
    }

    public function store(NewPasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );


        if ($status == Password::PASSWORD_RESET) {
            // return redirect()->route('login')->with('status', __($status));
            OldPassword::create([
                'email' => $request['email'],
                'old_password' => Hash::make($request['password']),
                'keep_old_password' => $request['keep_old_password']
            ]);

            return $this->success(null, 200, "Password Has Been Reset, Please Login");
        }

        throw ValidationException::withMessages([
            "message" => [trans($status)],
        ]);
    }
}
