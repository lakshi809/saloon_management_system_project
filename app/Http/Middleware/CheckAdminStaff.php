<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminStaff
{
    /**
     * Handle an incoming request.
     *
     * Allows access only to users with role 'admin' or 'staff'.
     * Blocks 'client' role users from accessing the route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'staff'])) {
            return $next($request);
        }

        // Not authorized - block access
        abort(403, 'Unauthorized. Only Admin and Staff can access this.');
    }
}