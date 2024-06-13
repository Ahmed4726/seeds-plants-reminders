@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Cycles with tag: {{ $tag->tag }}</h1>
    @foreach ($cycles as $cycle)
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title">{{ $cycle->name }}</h2>
            <p class="card-text">Start Date: {{ $cycle->start_date }}</p>
            <h3>Tasks:</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    {{ $cycle->task_name }} ({{ $cycle->days_from_start }} days from start) - Reminder:
                    {{ $cycle->reminder ? 'Yes' : 'No' }}
                </li>
                <li class="list-group-item">
                    <h4>Tag: {{ $tag->tag }}</h4>
                </li>
            </ul>
        </div>
    </div>
    @endforeach
</div>
@endsection
