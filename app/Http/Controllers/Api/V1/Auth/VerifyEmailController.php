<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    use ApiResponse;
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request)
    {


        if ($request->user()->hasVerifiedEmail()) {
            //  return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            return $this->success(null, 200, 'Email is Already Verified . Thank You !');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        //return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');

        return $this->success(null, 200, 'Email is Verified . Thank You !');
    }

    public function verifyBeforeLogin(Request $request)
    {

        $user = User::find($request->route('id'));
        if ($user) {
            if (!hash_equals((string) $request->route('id'), (string) $user->getKey())) {
                throw new AuthorizationException;
            }

            if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
                throw new AuthorizationException;
            }

            if ($user->hasVerifiedEmail()) {
                return $this->success(null, 200, 'Email is Already Verified . Thank You !');
            }

            if ($user->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            return $this->success(null, 200, 'Email is Verified . Thank You !');
        } else {
            return $this->error("Something Wrong !", 204);
        }
    }
}
