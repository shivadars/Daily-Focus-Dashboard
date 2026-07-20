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

    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Missed Start Time: ' . $this->task->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.overdue-task',
        );
    }
}
