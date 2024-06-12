@extends('layouts.main')
@section('content')
<h1>Choose a Template</h1>

<form method="POST" action="{{ route('cycles.selectTemplate') }}">
    @csrf
    <div class="form-group">
        <label for="template_id">Select Template</label>
        <select name="template_id" id="template_id" class="form-control">
            <option value="">No Template</option>
            @foreach ($templates as $template)
                <option value="{{ $template->id }}">{{ $template->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Next</button>
</form>
@endsection
