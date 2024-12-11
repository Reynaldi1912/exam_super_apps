<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;

class AuthControllers extends Controller
{
    public function login($username, $id, $token) {
        // Menghapus semua sesi sebelumnya
        Session::flush();
    
        // URL API
        $url = config('app.url') . '/users?id=' . $id;
    
        // Inisialisasi cURL
        $ch = curl_init($url);
    
        // Opsi cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token"
        ]);
    
        // Eksekusi cURL
        $response = curl_exec($ch);
    
        // Periksa apakah ada error pada cURL
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            die("cURL Error: $error");
        }
    
        // Tutup cURL
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
