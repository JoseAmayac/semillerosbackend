<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$role,$role2 = null)
    {
        if (Auth::check() && Auth::user()) {
            $user = Auth::user();
            if ($role2) {
                if ($user->hasRole($role) || $user->hasRole($role2)) {
                    return $next($request);
                }
            }else{
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
        }

        return response()->json([
            'code' => 'not_permission',
            'message' => 'No tiene el rol indicado para realizar esta acción'
        ],401);
    }
}
