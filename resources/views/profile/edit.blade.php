@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Profile Information</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <hr>

    <h1>Update Password</h1>

    <form method="POST" action="{{ route('profile.updatePassword') }}">
        @csrf

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
            @error('current_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
            @error('new_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <hr>

    <h1>Delete Account</h1>
    <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
</div>
@endsection
