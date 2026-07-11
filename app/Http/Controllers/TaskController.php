<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function storetask(Request $request)
    {
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);
        return redirect('/dashboard');
    }
    public function editask(Request $request, Task $task)
    {
        $task->update($request->only(
            [
                'title',
                'description',
                'priority'
            ]
        ));
        return redirect('/dashboard');
    }
    public function destroytask(Task $task)
    {
        $task->delete();
        return redirect('/dashboard');
    }
    public function toggleStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:completed,pending'
        ]);
        $task->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully',
            'new_status' => $task->status
        ]);
    }
}
