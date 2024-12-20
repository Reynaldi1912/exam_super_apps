<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminControllers_GET extends Controller
{
    public function index(Request $request){
        return view('dashboard');
    }
    public function users(Request $request){
        return view('client.admin.users');
    }
    public function grouping(Request $request){
        return view('client.admin.grouping');
    }
    public function questionbank(Request $request,$id){
        return view('client.admin.questionbank');
    }
    public function exam(Request $request){
        return view('client.admin.exam');
    }
    public function list_bank(Request $request){
        return view('client.admin.listQuestionBank');
    }
    public function results(Request $request){
        return view('client.admin.results');
    }
    public function list_results(Request $request){
        return view('client.admin.listResults');
    }
}
