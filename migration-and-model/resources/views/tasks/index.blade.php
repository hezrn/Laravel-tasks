<!DOCTYPE html>
<html>
<head>
    <title>Tasks List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial; background-color: #f5f3ff; padding: 20px; }
        h1 { color: #5b21b6; }
        a.button {
            background-color: #7c3aed; color: white; padding: 8px 15px; text-decoration: none;
            border-radius: 5px; margin-bottom: 10px; display: inline-block;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #c4b5fd; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #8b5cf6; color: white; }
        td { background-color: #ede9fe; }
        button, .edit-btn { background-color: #9333ea; color: white; border: none;
            padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-right:5px;
        }
        button:hover, .edit-btn:hover { background-color: #7e22ce; }
        input, textarea { width: 90%; padding: 5px; margin: 2px 0; border-radius:4px; border:1px solid #d8b4fe; }
        .hidden { display: none; }
        #message { margin-bottom:10px; font-weight:bold; color:green; }
    </style>
</head>
<body>

<h1>Task List</h1>

<div id="message"></div>

<h2>Create Task</h2>
<form id="taskForm">
    <input type="text" name="title" placeholder="Title" required>
    <br>
    <textarea name="description" placeholder="Description"></textarea>
    <br>
    <label><input type="checkbox" name="is_completed" value="1"> Completed</label>
    <br><br>
    <button type="submit">Save Task</button>
</form>

<h2>Tasks Table</h2>
<table id="tasksTable">
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    @foreach($tasks as $task)
    <tr data-id="{{ $task->id }}">
        <td class="title">{{ $task->title }}</td>
        <td class="description">{{ $task->description }}</td>
        <td class="status">@if($task->is_completed) Completed @else Pending @endif</td>
        <td>
            <button class="edit-btn">Edit</button>
            <button class="delete-btn">Delete</button>
        </td>
    </tr>
    @endforeach
</table>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Create Task
document.getElementById('taskForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let form = e.target;
    let data = new FormData(form);

    fetch('/tasks', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: data
    })
    .then(res => res.json())
    .then(task => {
        let table = document.getElementById('tasksTable');
        let row = document.createElement('tr');
        row.setAttribute('data-id', task.task.id);
        row.innerHTML = `
            <td class="title">${task.task.title}</td>
            <td class="description">${task.task.description}</td>
            <td class="status">${task.task.is_completed ? 'Completed' : 'Pending'}</td>
            <td>
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
            </td>
        `;
        table.appendChild(row);
        document.getElementById('message').innerText = 'Task created!';
        form.reset();
    })
    .catch(err => console.error(err));
});

// Handle Edit & Delete
document.getElementById('tasksTable').addEventListener('click', function(e) {
    let row = e.target.closest('tr');
    let taskId = row.getAttribute('data-id');

    // DELETE
    if(e.target.classList.contains('delete-btn')) {
        if(!confirm('Delete this task?')) return;
        fetch(`/tasks/${taskId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(res => res.json())
        .then(data => {
            row.remove();
            document.getElementById('message').innerText = 'Task deleted!';
        });
    }

    // EDIT
    if(e.target.classList.contains('edit-btn')) {
        // Replace row with editable inputs
        let title = row.querySelector('.title').innerText;
        let desc = row.querySelector('.description').innerText;
        let status = row.querySelector('.status').innerText;

        row.innerHTML = `
            <td><input type="text" value="${title}" class="edit-title"></td>
            <td><textarea class="edit-desc">${desc}</textarea></td>
            <td><input type="checkbox" class="edit-completed" ${status==='Completed'?'checked':''}></td>
            <td>
                <button class="save-edit-btn">Save</button>
                <button class="cancel-edit-btn">Cancel</button>
            </td>
        `;
    }

    // SAVE EDIT
    if(e.target.classList.contains('save-edit-btn')) {
        let title = row.querySelector('.edit-title').value;
        let desc = row.querySelector('.edit-desc').value;
        let completed = row.querySelector('.edit-completed').checked;

        let data = new FormData();
        data.append('title', title);
        data.append('description', desc);
        data.append('is_completed', completed ? 1 : 0);
        data.append('_method','PUT');

        fetch(`/tasks/${taskId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: data
        })
        .then(res => res.json())
        .then(task => {
            row.innerHTML = `
                <td class="title">${task.task.title}</td>
                <td class="description">${task.task.description}</td>
                <td class="status">${task.task.is_completed ? 'Completed' : 'Pending'}</td>
                <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </td>
            `;
            document.getElementById('message').innerText = 'Task updated!';
        });
    }

    // CANCEL EDIT
    if(e.target.classList.contains('cancel-edit-btn')) {
        // reload original row data
        fetch(`/tasks/${taskId}`)
        .then(res=>res.json())
        .then(task=>{
            row.innerHTML = `
                <td class="title">${task.task.title}</td>
                <td class="description">${task.task.description}</td>
                <td class="status">${task.task.is_completed ? 'Completed' : 'Pending'}</td>
                <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </td>
            `;
        });
    }

});
</script>

</body>
</html>