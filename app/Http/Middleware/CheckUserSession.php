<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        // Jika ada session username, lanjutkan ke permintaan berikutnya
        if (Session::has('username')) {
            return $next($request);
        }

        return redirect('/login-page');
    }
}
