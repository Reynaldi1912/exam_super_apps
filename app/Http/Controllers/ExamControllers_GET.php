<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class ExamControllers_GET extends Controller
{
   public function index(Request $request, $id)
    {
        // Session::forget('expired_exam');
        // Session::forget('exam_id');

        // $expiredTime = now()->addSeconds(30);
        // Session::put('expired_exam', $expiredTime);
        // Session::put('exam_id', $id);

        return view('client.users.exam', ['id' => $id]);
    }

    public function set_exam_session(Request $request){
        Session::forget('expired_exam');
        Session::forget('exam_id');

        $id = $request->exam_id;
        $end_date = Carbon::parse($request->end_date);
        $expiredExamUtc = now();
        
        $expiredTime = $end_date;      
        Session::put('expired_exam', $expiredTime);
        Session::put('exam_id', $id);
        Session::put('out', 0);


        return true;
    }

    public function updateSessionOnExam(){
        $sessionCount = Session::get('out') + 1;
        Session::put('out', $sessionCount);

        $result['success'] = true;
        $result['message'] = 'session count has set';
        return $result;
    }

}
