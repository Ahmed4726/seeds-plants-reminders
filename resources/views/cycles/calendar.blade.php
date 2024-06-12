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
            $('#calendar').fullCalendar({
                events: [
                    @foreach ($cycles as $cycle)
                        @foreach ($cycle->tasks as $task)
                            {
                                title: '{{ $task->name }}',
                                start: '{{ \Carbon\Carbon::parse($cycle->start_date)->addDays($task->days_from_start)->toDateString() }}'
                            },
                        @endforeach
                    @endforeach
                ]
            });
        });
    </script>
@endsection
