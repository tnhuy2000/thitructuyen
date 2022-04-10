<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isThuKyMiddleware
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
        if( Auth::check() && Auth::user()->role == 2 && Auth::user()->trangthai == 1){
            return $next($request);
        }
        //return redirect()->route('thuky.forbidden')->with('error_message', 'Người dùng không đủ quyền hạn để thao tác chức năng này!');
    }
}
