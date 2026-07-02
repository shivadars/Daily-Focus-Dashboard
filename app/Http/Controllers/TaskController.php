<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function storetask(Request $request){
        Task::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'priority'=>$request->priority,
        ]);
        return redirect('/dashboard');
    }
}
