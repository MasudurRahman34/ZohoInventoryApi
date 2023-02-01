<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\NewPasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;
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
        // $request->validate([
        //     'token' => 'required',
        //     'email' => 'required|email',
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
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

        //return $status;

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            // return redirect()->route('login')->with('status', __($status));
            return $this->success(null, 200, "Password Has Been Reset, Please Login");
        }

        throw ValidationException::withMessages([
            "message" => [trans($status)],
        ]);
    }
}
