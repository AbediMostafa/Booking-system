<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizeSuperUser
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

        if(!Auth::user()->isSuperUser()){
            return response()->json([
                'message' => 'شما اجازه دسترسی به این صفحه را ندارید'
            ], 403);
        }

        return $next($request);
    }
}
