<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->with('account')->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('authToken')->accessToken;

                // $user['tokenType'] = "Bearer";
                // $user['accessToken'] = $token;
                $response = [
                    'tokenType' => 'Bearer',
                    'token' => $token,
                    'user' => $user
                ];

                return $this->success($response, 200);
            } else {
                return $this->error("Password mismatch", 404);
            }
        } else {
            return $this->error('user does notfds exsit', 404);
        }
    }

    public function logout(Request $request)
    {
        // return ('working');
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
