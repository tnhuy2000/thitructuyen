<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isHoiDongThiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 4) && Auth::user()->trangthai == 1){
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
