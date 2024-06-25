@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-success" role="alert">
        You have registered successfully! Please verify your email to login.
    </div>
    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
</div>
@endsection
