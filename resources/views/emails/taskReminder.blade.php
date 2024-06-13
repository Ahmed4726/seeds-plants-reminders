<!DOCTYPE html>
<html>
<head>
    <title>Task Reminder</title>
</head>
<body>
    <h1>Task Reminder</h1>
    <p>Dear {{ $cycle->user->name }},</p>
    <p>This is a reminder for the task: <strong>{{ $task->name }}</strong>.</p>
    <p>Cycle: {{ $cycle->name }}</p>
    <p>Task Due Date: {{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start)->toDateString() }}</p>
    <p>Notes:</p>
    <ul>
        @foreach ($task->notes as $note)
            <li>{{ $note->note }}</li>
        @endforeach
    </ul>
    <p>Tags:</p>
    <ul>
        @foreach ($task->tags as $tag)
            <li>{{ $tag->tag }}</li>
        @endforeach
    </ul>
</body>
</html>
