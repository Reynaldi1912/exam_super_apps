<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = Session::get('role');

        if ($role != 'user' && $role != 'admin') {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
