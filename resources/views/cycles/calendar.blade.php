@extends('layouts.calander')
@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<div class="container">
    <h1>Task Calendar</h1>
    <div id='calendar'></div>
</div>

<script>
    $(document).ready(function() {
        const colors = ['#FF5733', '#FF5733', '#3357FF', '#3357FF', '#green', '#green']; // Add more colors if needed
        let colorIndex = 0;

        $('#calendar').fullCalendar({
        events: [
            @foreach ($cycles as $cycle)
                @foreach ($cycle->tasks as $task)
                    {
                        title: 'Start Date of the Cycle',
                        start: '{{ \Carbon\Carbon::parse($cycle->start_date)->toDateString() }}',
                        end: '{{ \Carbon\Carbon::parse($cycle->start_date)->toDateString() }}',
                        color: colors[colorIndex % colors.length],
                        rendering: 'background'
                    },
                    {
                        title: '{{ $task->name }}',
                        start: '{{ \Carbon\Carbon::parse($cycle->start_date)->toDateString() }}',
                        end: '{{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start)->toDateString() }}',
                        color: colors[colorIndex++ % colors.length],
                        rendering: 'background'
                    },
                    {
                        title: '{{ $task->name }}',
                        start: '{{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start)->toDateString() }}',
                        end: '{{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start + 1)->toDateString() }}',
                        color: colors[colorIndex++ % colors.length],
                    },
                @endforeach
            @endforeach
        ],
    });
});
</script>
@endsection
{{-- $(document).ready(function() {


    $('#calendar').fullCalendar({
        events: [
            @foreach ($cycles as $cycle)
                @foreach ($cycle->tasks as $task)
                    {
                        title: 'Start Date of the Cycle',
                        start: '{{ \Carbon\Carbon::parse($cycle->start_date)->toDateString() }}',
                        end: '{{ \Carbon\Carbon::parse($cycle->start_date)->toDateString() }}',
                        color: colors[colorIndex % colors.length],
                        rendering: 'background'
                    },
                    {
                        title: '{{ $task->name }}',
                        start: '{{ \Carbon\Carbon::parse($cycle->start_date)->toDateString() }}',
                        end: '{{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start)->toDateString() }}',
                        color: colors[colorIndex % colors.length],
                        rendering: 'background'
                    },
                    {
                        title: '{{ $task->name }}',
                        start: '{{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start)->toDateString() }}',
                        end: '{{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start + 1)->toDateString() }}',
                        color: colors[colorIndex % colors.length],
                    },
                @endforeach
            @endforeach
        ],
    });
}); --}}
