<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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

        if(count($roles) > 0) {
            foreach($roles as $r) {
                if (in_array($r, $user->groups())) {
                    return $next($request);
                }
            }
        }

        return redirect("/profile");
    }
}
