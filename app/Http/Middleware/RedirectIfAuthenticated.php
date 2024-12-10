<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Jika pengguna memiliki session `username`, redirect ke halaman utama
        if (Session::has('username')) {
            return redirect('/');
        }

        return $next($request);
    }
}
