<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class CheckPermissionInRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $permissionName)
    {
        // return $permissionName;
        $user = Auth::user();
        // $permission = Permission::where('name', $permissionName)->first();
        if ($user->hasPermissionTo($permissionName)) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Sorry ! Do Not Have Access Permission',
            'error' => \true,
            'data' => $user
        ], 401);
    }
}
