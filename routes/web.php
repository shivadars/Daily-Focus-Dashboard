<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/registeration', [AuthController::class, 'saveRegister']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/logincheck', [AuthController::class, 'checkLogin']);
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showdashBoard']);
    Route::post('/savetask', [TaskController::class, 'storetask']);
    Route::put('/tasks/{task}', [TaskController::class, 'editask']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroytask']);
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleStatus']);
});
