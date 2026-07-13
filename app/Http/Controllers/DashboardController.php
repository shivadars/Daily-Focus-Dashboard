<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    public function showdashBoard()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('dashboard', compact('tasks'));
    }
}

