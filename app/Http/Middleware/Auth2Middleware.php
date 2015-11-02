<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Auth2Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        $userRoles = $user->groups();
        $defRoles = array_intersect($userRoles, $roles);

        if(count($defRoles) > 0) {
            return $next($request);
        } else {
            return redirect('login2');
        }

    }
}
