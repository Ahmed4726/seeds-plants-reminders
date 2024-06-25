@extends('layouts.main')
@section('content')
<h1>Welcome to template page</h1>


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
    <form id="task-form" method="POST" action="{{ route('templates.store') }}">
        @csrf
        <div class="form-group">
            <label for="template-name">Template Name</label>
            <input type="text" class="form-control" id="template-name" name="template_name" required>
        </div>

        <button type="button" class="btn btn-primary" id="add-task-button">Add Task</button>


        <br>
        <br>
        <div id="tasks-container"></div>

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

                <input type="checkbox" id="reminder-${taskId}" name="tasks[${taskId}][reminder]" value="1" checked>
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

    function addNotes(taskId) {
        const notesContainer = document.getElementById(`notes-container-${taskId}`);
        const noteId = Date.now(); // Unique ID for each note

        const noteField = document.createElement('div');
        noteField.setAttribute('id', `note-${noteId}`);
        noteField.classList.add('form-group');

        noteField.innerHTML = `
            <label for="note-${noteId}">Note</label>
            <input type="text" class="form-control" id="note-${noteId}" name="tasks[${taskId}][notes][]" required>
        `;

        notesContainer.appendChild(noteField);
    }

    function addTags(taskId) {
        const tagsContainer = document.getElementById(`tags-container-${taskId}`);
        const tagId = Date.now(); // Unique ID for each tag

        const tagField = document.createElement('div');
        tagField.setAttribute('id', `tag-${tagId}`);
        tagField.classList.add('form-group');

        tagField.innerHTML = `
            <label for="tag-${tagId}">Tag</label>
            <input type="text" class="form-control" id="tag-${tagId}" name="tasks[${taskId}][tags][]" required>
        `;

        tagsContainer.appendChild(tagField);
    }

    function deleteTask(taskId) {
        const taskContainer = document.getElementById(`task-${taskId}`);
        taskContainer.remove();
    }
</script>
@endsection
