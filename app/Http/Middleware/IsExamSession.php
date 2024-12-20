<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
use Carbon\Carbon;

class IsExamSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now()->setTimezone('Asia/Jakarta'); // Mengambil waktu saat ini dalam zona waktu Jakarta
        $expiredExam = Carbon::parse(Session::get('expired_exam'))->setTimezone('Asia/Jakarta');
        
        // dd($expiredExam,$now);
        // Debugging dengan dd()
        if ($expiredExam > $now) {
            return $next($request);
        } else {
            Session::forget('expired_exam');
            Session::forget('exam_id');
            // Debug jika tidak memenuhi syarat
        }
        return redirect('/');
    }
    
    
}
