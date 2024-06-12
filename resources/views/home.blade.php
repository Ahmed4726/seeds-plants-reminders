@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Your Cycles</h1>

        <div class="row">
            @foreach ($cycles as $cycle)
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cycle->name }}</h5>
                            <p class="card-text"><strong>Start Date:</strong> {{ $cycle->start_date }}</p>
                            <h6 class="card-subtitle mb-2 text-muted">Tasks:</h6>
                            <ul class="list-group list-group-flush">
                                @foreach ($cycle->tasks as $task)
                                    <li class="list-group-item">
                                        {{ $task->name }} ({{ $task->days_from_start }} days from start)
                                        - Reminder: {{ $task->reminder ? 'Yes' : 'No' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($cycles->isEmpty())
            <p>No cycles found.</p>
        @endif
    </div>
@endsection
