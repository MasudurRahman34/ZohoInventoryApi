<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;

class VerifyEmailController extends Controller
{ use ApiResponse;
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        
        if ($request->user()->hasVerifiedEmail()) {
            //  return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            return $this->success(null,200,'Email is Already Verified . Thank You !');
            
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        //return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');

        return $this->success(null,200,'Email is Verified . Thank You !');
    }
}
