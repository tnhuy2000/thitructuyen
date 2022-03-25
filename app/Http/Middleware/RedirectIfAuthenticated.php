<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && Auth::user()->role == 1) {
                return redirect(RouteServiceProvider::ADMIN);
            }
            elseif(Auth::guard($guard)->check() && Auth::user()->role == 2 && Auth::user()->trangthai == 1)
            {
                return redirect(RouteServiceProvider::THUKY);
            }
            elseif(Auth::guard($guard)->check() && Auth::user()->role == 3)
            {
                return redirect(RouteServiceProvider::CANBOCOITHI);
            }
            elseif(Auth::guard($guard)->check() && Auth::user()->role == 4)
            {
                return redirect(RouteServiceProvider::HOIDONGTHI);
            }
            elseif(Auth::guard($guard)->check() && Auth::user()->role == 5 && Auth::user()->trangthai == 1)
            {
                return redirect(RouteServiceProvider::SINHVIEN);
            }
        }

        return $next($request);
    }
}
