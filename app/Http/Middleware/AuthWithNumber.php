<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthWithNumber
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
        if(auth()->guest()){
            return redirect('/phone-check/home');
        }

        return $next($request);
    }
}
