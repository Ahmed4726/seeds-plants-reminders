@extends('layouts.main')

@section('content')
    <h1>Tags</h1>
    <ul>
        @foreach ($tags as $tag)
            <li><a href="{{ route('tags.show', ['tag' => $tag->tag]) }}">{{ $tag->tag }}</a></li>
        @endforeach
    </ul>
@endsection
