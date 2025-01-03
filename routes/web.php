<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminControllers_GET;
use App\Http\Controllers\AuthControllers;
use App\Http\Controllers\ExamControllers_GET;
use App\Http\Controllers\UserControllers_GET;
use App\Http\Controllers\MasterControllers;
use App\Http\Middleware\CheckUserSession;
use App\Http\Middleware\IsExamSession;
use App\Http\Middleware\FetchUserTokens;
use App\Http\Middleware\RoleRedirect;
use App\Http\Middleware\RedirectIfAuthenticated;


Route::group(['middleware' => CheckUserSession::class], function () {
    Route::group(['middleware' => FetchUserTokens::class], function () {
        // Route::group(['middleware' => [RoleRedirect::class, 'admin']], function () {
            Route::get('/results', [AdminControllers_GET::class, 'results']);
            Route::get('/list-results', [AdminControllers_GET::class, 'list_results']);
            Route::get('/users', [AdminControllers_GET::class, 'users']);
            Route::get('/grouping', [AdminControllers_GET::class, 'grouping']);
            Route::get('/question-bank/{id}', [AdminControllers_GET::class, 'questionbank']);
            Route::get('/exam-data', [AdminControllers_GET::class, 'exam']);
            Route::get('/list-bank', [AdminControllers_GET::class, 'list_bank']);
            
            Route::get('/update-session-on-exam/', [ExamControllers_GET::class, 'updateSessionOnExam']);
            Route::get('/set-exam-session/', [ExamControllers_GET::class, 'set_exam_session']);
            Route::group(['middleware' => IsExamSession::class], function () {
                Route::get('/exam/{id}', [ExamControllers_GET::class, 'index']);
            });
            Route::get('/', [AdminControllers_GET::class, 'index']);
        });
        
        // Route::group(['middleware' => [RoleRedirect::class, 'user']], function () {
            // Route::get('/', [UserControllers_GET::class, 'index']);
        // });
        
    // });

    Route::get('/logout', [AuthControllers::class, 'logout']);
});

Route::get('/create-session/{username}/{id}/{token}', [AuthControllers::class, 'login'])->middleware(RedirectIfAuthenticated::class);;
Route::get('/login-page', function () {
    return view('login');
})->middleware(RedirectIfAuthenticated::class);;

Route::get('/check-session', [AuthControllers::class, 'getSession']);
Route::get('/updateSessionToken', [AuthControllers::class, 'updateSessionToken']);
