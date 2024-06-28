<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role3Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role, $secondRole, $thirdRole)
    {
        if (Auth::check() && Auth::user()->role == $role || Auth::check() && Auth::user()->role == $secondRole|| Auth::check() && Auth::user()->role == $thirdRole) {
            return $next($request);
        }
        return back();
    }
}
