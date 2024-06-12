@extends('layouts.main')
@section('content')
<h1>Create Cycle with Template: {{ $template->name }}</h1>

<form method="POST" action="{{ route('cycles.store') }}">
    @csrf
    <div class="form-group">
        <label for="cycle_name">Cycle Name</label>
        <input type="text" class="form-control" id="cycle_name" name="cycle_name" required>
    </div>
    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
    </div>

    <div id="tasks-container">
        @foreach ($template->tasks as $task)
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
                    <input type="checkbox" id="reminder-{{ $task->id }}" name="tasks[{{ $task->id }}][reminder]" value="{{ $task->reminder }}" {{ $task->reminder ? 'checked' : '' }} >
                    <label for="reminder-{{ $task->id }}">Reminder</label>
                </div>
                <div id="notes-container-{{ $task->id }}">
                    @foreach ($task->notes as $note)
                        <div class="form-group">
                            <label for="note-{{ $note->id }}">Note</label>
                            <input type="text" class="form-control" id="note-{{ $note->id }}" name="tasks[{{ $task->id }}][notes][]" value="{{ $note->note }}">
                        </div>
                    @endforeach
                </div>
                <div id="tags-container-{{ $task->id }}">
                    @foreach ($task->tags as $tag)
                        <div class="form-group">
                            <label for="tag-{{ $tag->id }}">Tag</label>
                            <input type="text" class="form-control" id="tag-{{ $tag->id }}" name="tasks[{{ $task->id }}][tags][]" value="{{ $tag->tag }}">
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-primary" onclick="addTask()">Add Task</button>
    <button type="submit" class="btn btn-success">Create</button>
</form>

<script>
    function addTask() {
        const taskId = Date.now();
        const taskContainer = document.createElement('div');
        taskContainer.setAttribute('id', `task-${taskId}`);
        taskContainer.classList.add('task');

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
            <div id="notes-container-${taskId}"></div>
            <div id="tags-container-${taskId}"></div>
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

        const noteField = document.createElement('div');
        noteField.classList.add('form-group');

        noteField.innerHTML = `
            <label for="note-${noteId}">Note</label>
            <input type="text" class="form-control" id="note-${noteId}" name="tasks[${taskId}][notes][]">
        `;

        notesContainer.appendChild(noteField);
    }

    function addTags(taskId) {
        const tagsContainer = document.getElementById(`tags-container-${taskId}`);
        const tagId = Date.now();

        const tagField = document.createElement('div');
        tagField.classList.add('form-group');

        tagField.innerHTML = `
            <label for="tag-${tagId}">Tag</label>
            <input type="text" class="form-control" id="tag-${tagId}" name="tasks[${taskId}][tags][]">
        `;

        tagsContainer.appendChild(tagField);
    }

    function deleteTask(taskId) {
        const taskContainer = document.getElementById(`task-${taskId}`);
        taskContainer.remove();
    }
</script>
@endsection
