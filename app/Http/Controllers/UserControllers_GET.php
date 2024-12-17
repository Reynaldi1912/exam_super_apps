<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserControllers_GET extends Controller
{
    public function index(Request $request){
        return view('client.users.dashboard');
    }
}
