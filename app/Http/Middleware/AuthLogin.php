<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class AuthLogin
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

        if ($request->hasCookie('Username_server')) {
            if ($request->cookie('Username_server') != '') {
                return $next($request);
            }
            return redirect()->route('login');
        }

        return redirect()->route('login');
    }
}
