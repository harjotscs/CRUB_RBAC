<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\HasAccessMiddleware;


Route::post('register', [RegisterController::class, 'register'])->middleware(HasAccessMiddleware::class . ':create_user');
Route::post('login', [LoginController::class, 'login']);

Route::get('/user/getDetails', [UserController::class, 'getDetails'])->middleware(HasAccessMiddleware::class . ':read_user');

Route::get('/users', [UserController::class, 'index'])->middleware(HasAccessMiddleware::class . ':read_users');
Route::post('/users', [UserController::class, 'store'])->middleware(HasAccessMiddleware::class . ':create_user');
Route::patch('/users/{id}', [UserController::class, 'update'])->middleware(HasAccessMiddleware::class . ':update_user');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware(HasAccessMiddleware::class . ':delete_user');

