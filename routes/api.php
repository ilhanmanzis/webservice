<?php

use App\Http\Controllers\Film;
use App\Http\Controllers\Actor;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Classes;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Category;
use App\Http\Controllers\Feedbacks;
use App\Http\Controllers\Materials;
use App\Http\Controllers\Categories;

use App\Http\Controllers\Enrollments;
use Illuminate\Support\Facades\Route;

//classes
Route::get('/classes', [Classes::class, 'index']);
Route::get('/classes/{id}', [Classes::class, 'show']);
//material
Route::get('/classes/{id}/materials', [Materials::class, 'index']);
Route::get('/materials/{id}', [Materials::class, 'show']);
//Teacher
Route::get('/teachers', [Teacher::class, 'index']);
Route::get('/teachers/{id}', [Teacher::class, 'show']);
//categories
Route::get('/categories', [Categories::class, 'index']);

//enrollments
Route::post('/enrollments', [Enrollments::class, 'store']);

//feedbacks
Route::post('/feedbacks', [Feedbacks::class, 'store']);

//users
Route::post('/auth/register', [Auth::class, 'store']);
