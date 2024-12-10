<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminControllers_GET;
use App\Http\Controllers\AuthControllers;
use App\Http\Controllers\ExamControllers_GET;
use App\Http\Controllers\MasterControllers;
use App\Http\Middleware\CheckUserSession;
use App\Http\Middleware\RedirectIfAuthenticated;


Route::group(['middleware' => CheckUserSession::class], function () {
    Route::get('/', [AdminControllers_GET::class, 'index']);
    Route::get('/users', [AdminControllers_GET::class, 'users']);
    Route::get('/grouping', [AdminControllers_GET::class, 'grouping']);
    Route::get('/question-bank/{id}', [AdminControllers_GET::class, 'questionbank']);
    Route::get('/exam-data', [AdminControllers_GET::class, 'exam']);
    Route::get('/list-bank', [AdminControllers_GET::class, 'list_bank']);

    Route::get('/exam', [ExamControllers_GET::class, 'index']);
    Route::get('/logout', [AuthControllers::class, 'logout']);
});

Route::get('/create-session/{username}/{id}/{token}', [AuthControllers::class, 'login'])->middleware(RedirectIfAuthenticated::class);;
Route::get('/login-page', function () {
    return view('login');
})->middleware(RedirectIfAuthenticated::class);;

Route::get('/check-session', [AuthControllers::class, 'getSession']);