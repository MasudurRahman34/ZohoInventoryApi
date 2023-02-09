<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class guestApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->check()) {

            $message = ["message" => "You Are In Login . Permisison denied !"];
            return response($message, 403);
        } else {
            return $next($request);
            //return response(Auth::user());
        }
    }
}
