@extends('layouts.main')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container">
    <h1>Your Cycles</h1>

    <div class="row">
        @foreach ($cycles as $cycle)
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body position-relative">
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
                        <div class="position-absolute top-0 end-0 m-2">
                            <a href="{{ route('cycles.edit', $cycle->id) }}"><i class="fas fa-edit text-secondary"></i></a>
                            <form action="{{ route('cycles.destroy', $cycle->id) }}" method="POST" style="display:inline;">
                                @csrf
                                {{-- @method('DELETE') --}}
                                <button type="submit" class="btn"><i class="fas fa-trash text-secondary"></i></button>
                            </form>
                        </div>
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
