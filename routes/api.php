<?php


use App\Http\Controllers\Auth;
use App\Http\Controllers\Classes;
use App\Http\Controllers\Teacher;

use App\Http\Controllers\Feedbacks;
use App\Http\Controllers\Materials;
use App\Http\Controllers\Categories;

use App\Http\Controllers\Enrollments;
use App\Http\Controllers\Users;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::withoutMiddleware('jwtAuth')->group(function () {
    Route::post('/auth/register', [Auth::class, 'store']);
    Route::post('/auth/login', [Auth::class, 'login']);
});




//classes
Route::get('/classes', [Classes::class, 'index']);
Route::get('/classes/{id}', [Classes::class, 'show']);

//my classes
Route::get('/my-classes', [Enrollments::class, 'show']);

//material
Route::get('/classes/{id}/materials', [Materials::class, 'index']);
Route::get('/materials/{id}', [Materials::class, 'show']);
//Teacher
Route::get('/teachers', [Teacher::class, 'index']);
Route::get('/teachers/{id}', [Teacher::class, 'show']);
//categories
Route::get('/categories', [Categories::class, 'index']);
Route::get('/categories/{id}', [Categories::class, 'show']);

//enrollments
Route::post('/enrollments', [Enrollments::class, 'store']);

//feedbacks
Route::post('/feedbacks', [Feedbacks::class, 'store']);
Route::get('/classes/{id}/feedbacks', [Feedbacks::class, 'index']);

//users

Route::get('/users/{id}', [Users::class, 'show']);
Route::get('/my-profile', [Users::class, 'profile']);
