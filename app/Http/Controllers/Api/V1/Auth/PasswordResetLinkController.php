<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PasswordResetLinkRequest;
use App\Jobs\v1\QueuedSendPasswordResetLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


class PasswordResetLinkController extends Controller
{
    use ApiResponse;
    public function store(PasswordResetLinkRequest $request)
    {

        QueuedSendPasswordResetLink::dispatch($request->only('email'));
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );
        return $this->success("Password Reset Link Has Been Sent");
    }
}
