<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;

class AuthControllers extends Controller
{
    public function login($username, $id , $token) {
        // Menghapus sesi lama
        Session::forget('username');
        Session::forget('id');
        Session::forget('token');
        
        // Menyimpan sesi baru dengan username dan id yang baru
        Session::put('username', $username);
        Session::put('id', $id);
        Session::put('token', $token);
    
        // Redirect ke halaman utama setelah sesi berhasil diupdate
        return redirect('/');
    }
    public function logout() {
        // Menghapus sesi lama
        Session::forget('token');
        Session::forget('username');
        Session::forget('id');
    
        // Redirect ke halaman utama setelah sesi berhasil diupdate
        return redirect('/');
    }

    public function getSession(){
        // Ambil nilai dari sesi
        $token = Session::get('token');
        $id = Session::get('id');
        $username = Session::get('username');
    
        // Simpan nilai dalam array associatif
        $result = [
            'token' => $token,
            'id' => $id,
            'username' => $username
        ];
    
        // Kembalikan sebagai response JSON
        return response()->json($result);
    }
    
    
}
