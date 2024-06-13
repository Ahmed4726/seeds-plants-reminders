@extends('layouts.main')

@section('content')
<h1>Edit Cycle</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container">
    <form id="task-form" method="POST" action="{{ route('cycles.update', $cycle->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="cycle-name">Cycle Name</label>
            <input type="text" class="form-control" id="cycle-name" name="cycle_name" value="{{ $cycle->name }}" required>
        </div>

        <div class="form-group">
            <label for="start-date">Start Date</label>
            <input type="date" class="form-control" id="start-date" name="start_date" value="{{ $cycle->start_date }}" required>
        </div>

        <button type="button" class="btn btn-primary" id="add-task-button">Add Task</button>

        <br>
        <br>
        <div id="tasks-container">
            @foreach($cycle->tasks as $task)
            <div class="task" id="task-{{ $task->id }}">
                <div class="form-group">
                    <label for="task-name-{{ $task->id }}">Task Name</label>
                    <input type="text" class="form-control" id="task-name-{{ $task->id }}" name="tasks[{{ $task->id }}][name]" value="{{ $task->name }}" required>
                </div>
                <div class="form-group">
                    <label for="days-from-start-{{ $task->id }}">Days from Start Date</label>
                    <input type="number" class="form-control" id="days-from-start-{{ $task->id }}" name="tasks[{{ $task->id }}][days_from_start]" value="{{ $task->days_from_start }}" required>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="reminder-{{ $task->id }}" name="tasks[{{ $task->id }}][reminder]" value="1" {{ $task->reminder ? 'checked' : '' }}>
                    <label for="reminder-{{ $task->id }}">Reminder</label>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-info" onclick="addNotes({{ $task->id }})">Add Notes</button>
                    <button type="button" class="btn btn-info" onclick="addTags({{ $task->id }})">Add Tags</button>
                </div>
                <div id="notes-container-{{ $task->id }}">
                    @foreach($task->notes as $note)
                    <div class="form-group">
                        <label for="note-{{ $note->id }}">Note</label>
                        <input type="text" class="form-control" id="note-{{ $note->id }}" name="tasks[{{ $task->id }}][notes][]" value="{{ $note->note }}">
                    </div>
                    @endforeach
                </div>
                <div id="tags-container-{{ $task->id }}">
                    @foreach($task->tags as $tag)
                    <div class="form-group">
                        <label for="tag-{{ $tag->id }}">Tag</label>
                        <input type="text" class="form-control" id="tag-{{ $tag->id }}" name="tasks[{{ $task->id }}][tags][]" value="{{ $tag->tag }}">
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-danger" onclick="deleteTask({{ $task->id }})">Delete Task</button>
                <hr>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

<script>
    document.getElementById('add-task-button').addEventListener('click', function() {
        addTask();
    });

    function addTask() {
        const taskId = Date.now(); // Unique ID for each task
        const taskContainer = document.createElement('div');
        taskContainer.className = 'task';
        taskContainer.id = 'task-' + taskId;

        taskContainer.innerHTML = `
            <div class="form-group">
                <label for="task-name-${taskId}">Task Name</label>
                <input type="text" class="form-control" id="task-name-${taskId}" name="tasks[${taskId}][name]" required>
            </div>
            <div class="form-group">
                <label for="days-from-start-${taskId}">Days from Start Date</label>
                <input type="number" class="form-control" id="days-from-start-${taskId}" name="tasks[${taskId}][days_from_start]" required>
            </div>
            <div class="form-group">
                <input type="checkbox" id="reminder-${taskId}" name="tasks[${taskId}][reminder]" value="1">
                <label for="reminder-${taskId}">Reminder</label>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-info" onclick="addNotes(${taskId})">Add Notes</button>
                <button type="button" class="btn btn-info" onclick="addTags(${taskId})">Add Tags</button>
            </div>
            <div id="notes-container-${taskId}"></div>
            <div id="tags-container-${taskId}"></div>
            <button type="button" class="btn btn-danger" onclick="deleteTask(${taskId})">Delete Task</button>
            <hr>
        `;

        document.getElementById('tasks-container').appendChild(taskContainer);
    }

    function deleteTask(taskId) {
        const taskElement = document.getElementById('task-' + taskId);
        taskElement.remove();
    }

    function addNotes(taskId) {
        const notesContainer = document.getElementById('notes-container-' + taskId);
        const noteInput = document.createElement('div');
        noteInput.className = 'form-group';
        noteInput.innerHTML = `
            <label for="note-${Date.now()}">Note</label>
            <input type="text" class="form-control" name="tasks[${taskId}][notes][]">
        `;
        notesContainer.appendChild(noteInput);
    }

    function addTags(taskId) {
        const tagsContainer = document.getElementById('tags-container-' + taskId);
        const tagInput = document.createElement('div');
        tagInput.className = 'form-group';
        tagInput.innerHTML = `
            <label for="tag-${Date.now()}">Tag</label>
            <input type="text" class="form-control" name="tasks[${taskId}][tags][]">
        `;
        tagsContainer.appendChild(tagInput);
    }
</script>
@endsection
