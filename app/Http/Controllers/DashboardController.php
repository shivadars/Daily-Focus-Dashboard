<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    public function showdashBoard(){
        $tasks=Task::all();
        return view('dashboard',compact('tasks'));
    }
}
