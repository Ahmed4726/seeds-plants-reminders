@extends('layouts.main')
@section('content')
<div class="container">
    <h1>Create Cycle without Template</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('cycles.store') }}">
        @csrf
        <div class="form-group">
            <label for="cycle_name">Cycle Name</label>
            <input type="text" class="form-control" id="cycle_name" name="cycle_name" value="{{ old('cycle_name', $cycleData['cycle_name'] ?? '') }}" required>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $cycleData['start_date'] ?? '') }}" required>
        </div>

        <div id="tasks-container"></div>

        <button type="button" class="btn btn-primary" onclick="addTask()">Add Task</button>
        {{-- <br> --}}
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (!empty($cycleData['tasks']))
            @foreach ($cycleData['tasks'] as $taskId => $task)
                addTask({
                    name: '{{ $task['name'] }}',
                    days_from_start: '{{ $task['days_from_start'] }}',
                    reminder: '{{ $task['reminder'] ?? 0 }}',
                    notes: {!! json_encode($task['notes'] ?? []) !!},
                    tags: {!! json_encode($task['tags'] ?? []) !!}
                });
            @endforeach
        @endif
    });

    function addTask(existingTask = null) {
        const taskId = Date.now();
        const taskContainer = document.createElement('div');
        taskContainer.setAttribute('id', `task-${taskId}`);
        taskContainer.classList.add('task', 'mb-3', 'border', 'p-3');

        taskContainer.innerHTML = `
            <div class="form-group">
                <label for="task-name-${taskId}">Task Name</label>
                <input type="text" class="form-control" id="task-name-${taskId}" name="tasks[${taskId}][name]" value="${existingTask ? existingTask.name : ''}" required>
            </div>
            <div class="form-group">
                <label for="days-from-start-${taskId}">Days from Start Date</label>
                <input type="number" class="form-control" id="days-from-start-${taskId}" name="tasks[${taskId}][days_from_start]" value="${existingTask ? existingTask.days_from_start : ''}" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="reminder-${taskId}" name="tasks[${taskId}][reminder]" value="1" ${existingTask && existingTask.reminder == 1 ? 'checked' : ''}>
                <label class="form-check-label" for="reminder-${taskId}">Reminder</label>
            </div>
            <div id="notes-container-${taskId}">
                ${existingTask ? existingTask.notes.map(note => addNoteField(taskId, note)).join('') : ''}
            </div>
            <div id="tags-container-${taskId}">
                ${existingTask ? existingTask.tags.map(tag => addTagField(taskId, tag)).join('') : ''}
            </div>
            <button type="button" class="btn btn-info" onclick="addNotes(${taskId})">Add Notes</button>
            <button type="button" class="btn btn-info" onclick="addTags(${taskId})">Add Tags</button>
            <button type="button" class="btn btn-danger" onclick="deleteTask(${taskId})">Delete Task</button>
            <hr>
        `;

        document.getElementById('tasks-container').appendChild(taskContainer);
    }

    function addNotes(taskId) {
        const notesContainer = document.getElementById(`notes-container-${taskId}`);
        const noteId = Date.now();
        notesContainer.insertAdjacentHTML('beforeend', addNoteField(taskId));
    }

    function addNoteField(taskId, note = '') {
        const noteId = Date.now();
        return `
            <div class="form-group">
                <label for="note-${noteId}">Note</label>
                <input type="text" class="form-control" id="note-${noteId}" name="tasks[${taskId}][notes][]" value="${note}">
            </div>
        `;
    }

    function addTags(taskId) {
        // const tagsContainer = document.getElementById(`tags-container-${taskId}`);
        const tagsContainer = document.getElementById(`tags-container-${taskId}`);
        const tagId = Date.now();
        tagsContainer.insertAdjacentHTML('beforeend', addTagField(taskId));
    }

    function addTagField(taskId, tag = '') {
        const tagId = Date.now();
        return `
            <div class="form-group">
                <label for="tag-${tagId}">Tag</label>
                <input type="text" class="form-control" id="tag-${tagId}" name="tasks[${taskId}][tags][]" value="${tag}">
            </div>
        `;
    }

    function deleteTask(taskId) {
        const taskContainer = document.getElementById(`task-${taskId}`);
        taskContainer.remove();
    }
</script>
@endsection

