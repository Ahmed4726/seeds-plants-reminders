@extends('layouts.main')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container">
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="/templates/create">Create New Template</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Tasks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($templates as $template)
            <tr>
                <td>{{ $template->id }}</td>
                <td>{{ $template->name }}</td>
                <td>{{ $template->created_at }}</td>
                <td>{{ $template->task_count }}</td>
                <td>
                    <a href="/templates/edit/{{ $template->id }}" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                    <form action="/templates/delete/{{ $template->id }}" method="POST" style="display:inline;">
                        @csrf
                        {{-- @method('DELETE') --}}
                        <button type="submit" class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
