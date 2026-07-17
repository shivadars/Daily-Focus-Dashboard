<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OverdueTaskMail extends Mailable
{
    use Queueable, SerializesModels;

    public Task $task;  // ← store the task here

    public function __construct(Task $task)  // ← receive the task
    {
        $this->task = $task;
    }

    // Subject line of the email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⏰ Missed Start Time: ' . $this->task->title,
        );
    }

    // Which blade template to use as the email body
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.overdue-task',
        );
    }
}
