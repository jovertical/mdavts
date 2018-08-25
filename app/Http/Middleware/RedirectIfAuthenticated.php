<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch (Auth::user()->type) {
                case 'admin':
                    return redirect()->route('root.dashboard');
                break;

                case 'user':
                    return redirect()->route('front.dashboard');
                break;
            }
        }

        return $next($request);
    }
}
