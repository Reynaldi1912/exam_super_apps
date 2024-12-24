<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;

class FetchUserTokens
{
    public function handle($request, Closure $next)
    {
        $url = config('app.url');

        if (Session::has('token_user')) {
            $userId = Session::get('user_id');
            $urluser = $url . "/getTokenUser?userId=" . $userId;
            $urlapp  = $url . "/getTokenApp?userId=" . $userId;
        
            try {
                $userResponse = file_get_contents($urluser);
                $appResponse = file_get_contents($urlapp);

                $userData = json_decode($userResponse, true);
                $appData = json_decode($appResponse, true);

                // echo json_encode($appData);
                if (isset($userData['data']['token_app'], $appData['data']['token']) &&
                    $userData['data']['token_app'] === $appData['data']['token']) {
                    return $next($request); // Lanjutkan request jika token valid
                } else {
                    return response()->view('tokenNotValid'); // Kembalikan view dengan response
                }
            } catch (\Exception $e) {
                return response()->view('tokenNotValid', ['error' => 'Failed to fetch tokens']);
            }
        }

        // Jika tidak ada token, kembalikan error atau redirect
        return redirect('/login-page')->with('error', 'Session expired or token missing.');
    }
}
