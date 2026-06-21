<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/registeration',[AuthController::class,'saveRegister']);
Route::get('/login',[AuthController::class,'showLogin']);
Route::post('/logincheck',[AuthController::class,'checkLogin']);
