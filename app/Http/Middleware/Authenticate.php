<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
class Authenticate extends Middleware
{
    use ApiResponse;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
         //return route('login.api');
            return $this->error('Unauthorized ! Please Log In Or Sign Up !',401,['signup'=>'link', 'login'=>
            'link']);
        }
    }
}
