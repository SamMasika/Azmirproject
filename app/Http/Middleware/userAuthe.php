<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class userAuthe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {$token = \Illuminate\Support\Facades\Request::cookie('access_token');
        if (empty($token))
        {
            $message = 'Your session has expired';
            Session::flash('error',''.$message);
            return redirect('/');
        }
        return $next($request);
    }
}
