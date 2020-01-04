<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userCount = User::all()->count();
        // if only 1 user, assume it is an Admin
        if (!($userCount == 1)) {
            if (!Auth::user()->is_admin) //If user does not have this permission
            {
                abort('401');
            }
        }

        return $next($request);
    }
}
