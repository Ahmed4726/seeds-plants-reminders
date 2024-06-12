
@extends('layouts.main')
@section('content')
<h1>Confirm Cycle</h1>

<div class="form-group">
    <label>Cycle Name:</label>
    <p>{{ $cycleData['cycle_name'] }}</p>
</div>
<div class="form-group">
    <label>Start Date:</label>
    <p>{{ $cycleData['start_date'] }}</p>
</div>

<h2>Tasks</h2>
@foreach ($cycleData['tasks'] as $task)
    <div class="task">
        <div class="form-group">
            <label>Task Name:</label>
            <p>{{ $task['name'] }}</p>
        </div>
        <div class="form-group">
            <label>Days from Start Date:</label>
            <p>{{ $task['days_from_start'] }}</p>
        </div>
        <div class="form-group">
            <label>Reminder:</label>
            <p>{{ $task['reminder'] ? 'Yes' : 'No' }}</p>
        </div>
        @if (isset($task['notes']))
            <div class="form-group">
                <label>Notes:</label>
                <ul>
                    @foreach ($task['notes'] as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (isset($task['tags']))
            <div class="form-group">
                <label>Tags:</label>
                <ul>
                    @foreach ($task['tags'] as $tag)
                        <li>{{ $tag }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endforeach

<form method="POST" action="{{ route('cycles.confirm') }}">
    @csrf
    <button type="submit" class="btn btn-success">Confirm</button>
    <a href="{{ route('cycles.createNoTemplate') }}" class="btn btn-primary">Edit</a>
</form>
@endsection
