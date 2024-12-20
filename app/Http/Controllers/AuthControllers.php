<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;



class AuthControllers extends Controller
{

    function updateSessionToken(Request $request){
        $newToken = $request->input('new_token');
        Session::put('token_user', $newToken);
        return response()->json(['success' => true, 'message' => 'Session token updated successfully']);
    }
    public function login($username, $id, $token) {
        // Menghapus semua sesi sebelumnya
        Session::flush();
    
        $url = config('app.url') . '/users?id=' . $id;

        $ch = curl_init($url);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token"
        ]);
    
        $response = curl_exec($ch);
    
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            die("cURL Error: $error");
        }
    
        curl_close($ch);
    
        // Decode JSON response
        $decodedResponse = json_decode($response, true);
        // Periksa validitas JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("JSON Decode Error: " . json_last_error_msg());
        }
    
        // Periksa apakah data ditemukan
        if (!isset($decodedResponse['data'][0])) {
            die("Invalid response format: data not found");
        }
    
        $userData = $decodedResponse['data'][0];

        foreach ($userData as $key => $value) {
            Session::put($key, $value);
        }
    
        // Redirect ke halaman utama
        return redirect('/');
    }
    
    public function logout() {
        Session::flush();
    
        return redirect('/');
    }

    public function getSession(){
        return response()->json( Session::all());

    }
    
    
}
