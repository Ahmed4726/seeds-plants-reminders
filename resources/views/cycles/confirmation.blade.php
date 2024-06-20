@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4">Confirm Cycle</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Cycle Details</h2>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="font-weight-bold">Cycle Name:</label>
                <p>{{ $cycleData['cycle_name'] }}</p>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Start Date:</label>
                <p>{{ $cycleData['start_date'] }}</p>
            </div>
        </div>
    </div>

    <h2 class="mb-3">Tasks</h2>
    @foreach ($cycleData['tasks'] as $task)
    {{-- @dd($task) --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">Task Name:</label>
                    <p>{{ $task['name'] }}</p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Days from Start Date:</label>
                    <p>{{ $task['days_from_start'] }}</p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Reminder:</label>
                    <p>{{ isset($task['reminder']) ? 'Yes' : 'No' }}</p>
                </div>
                @if (isset($task['notes']))
                    <div class="form-group">
                        <label class="font-weight-bold">Notes:</label>
                        <ul>
                            @foreach ($task['notes'] as $note)
                                <li>{{ $note }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (isset($task['tags']))
                    <div class="form-group">
                        <label class="font-weight-bold">Tags:</label>
                        <ul>
                            @foreach ($task['tags'] as $tag)
                                <li>{{ $tag }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <form method="POST" action="{{ route('cycles.confirm') }}">
        @csrf
        <button type="submit" class="btn btn-success">Confirm</button>
        <a href="{{ route('cycles.createNoTemplate') }}" class="btn btn-primary">Edit</a>
    </form>
</div>
@endsection
