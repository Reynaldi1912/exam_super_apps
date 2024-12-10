<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminControllers_GET;
use App\Http\Controllers\ExamControllers_GET;
use App\Http\Controllers\MasterControllers;

Route::get('/', [AdminControllers_GET::class, 'index']);
Route::get('/users', [AdminControllers_GET::class, 'users']);
Route::get('/grouping', [AdminControllers_GET::class, 'grouping']);
Route::get('/question-bank/{id}', [AdminControllers_GET::class, 'questionbank']);
Route::get('/exam-data', [AdminControllers_GET::class, 'exam']);
Route::get('/list-bank', [AdminControllers_GET::class, 'list_bank']);

Route::get('/exam', [ExamControllers_GET::class, 'index']);
