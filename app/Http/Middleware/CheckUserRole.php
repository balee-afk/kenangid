<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->usertype === $role) {
            return $next($request);
        }

        // Jika pengguna tidak memiliki akses
        return response()->view('errors.no-access', [], 403);
    }
}
