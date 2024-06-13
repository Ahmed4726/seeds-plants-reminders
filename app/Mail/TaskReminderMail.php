<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $cycle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task, $cycle)
    {
        $this->task = $task;
        $this->cycle = $cycle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Task Reminder')
                    ->view('emails.taskReminder');
    }
}
