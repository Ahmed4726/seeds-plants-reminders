<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Mail\TaskReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'send:task-reminders';

    protected $description = 'Send task reminders to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();

        $cycles = Cycle::with(['tasks', 'user', 'tasks.notes', 'tasks.tags'])
            ->whereHas('tasks', function ($query) use ($today) {
                $query->where('reminder', 1)
                      ->whereRaw('DATE_ADD(start_date, INTERVAL days_from_start DAY) = ?', [$today]);
            })
            ->get();

        foreach ($cycles as $cycle) {
            foreach ($cycle->tasks as $task) {
                $taskDueDate = Carbon::parse($cycle->start_date)->addDays($task->days_from_start);

                if ($task->reminder && $taskDueDate->isToday()) {
                    Mail::to($cycle->user->email)->send(new TaskReminderMail($task, $cycle));
                }
            }
        }

        $this->info('Task reminders have been sent successfully.');
    }
}
