<?php

namespace App\Console\Commands;

use App\Mail\OverdueTaskMail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckOverdueTasks extends Command
{
    // The name you use to run it in terminal
    protected $signature = 'tasks:check-overdue';

    // Description shown in php artisan list
    protected $description = 'Email users whose tasks have missed their planned start time';

    public function handle()
    {
        $now = now()->format('H:i:s');

        // Find all pending tasks where start_time has already passed
        $overdueTasks = Task::where('status', 'pending')
            ->whereNotNull('start_time')
            ->where('start_time', '<', $now)
            ->with('user')
            ->get();

        if ($overdueTasks->isEmpty()) {
            $this->info('No overdue tasks found.');
            return;
        }

        // Send email for each overdue task
        foreach ($overdueTasks as $task) {
            $user = User::find($task->user_id);
            Mail::to($user->email)->send(new OverdueTaskMail($task));
            $this->info("✅ Email sent for: {$task->title} → {$user->email}");
        }

        $this->info("Done! {$overdueTasks->count()} alert(s) sent.");
    }
}
