@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Cycles with Tag: {{ $tag->tag }}</h1>
        @foreach ($cycles as $cycle)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $cycle->name }}</h5>
                    <p class="card-text">Start Date: {{ $cycle->start_date }}</p>
                    <h6>Tasks:</h6>
                    <ul>
                        @foreach ($cycle->tasks as $task)
                            <li>{{ $task->name }} ({{ $task->days_from_start }} days from start) - Reminder: {{ $task->reminder ? 'Yes' : 'No' }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endsection
