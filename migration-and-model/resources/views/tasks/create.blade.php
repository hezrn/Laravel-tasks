<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
    <style>
        body { font-family: Arial; background-color: #f5f3ff; padding: 20px; }
        h1 { color: #5b21b6; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; border-radius: 4px; border: 1px solid #d8b4fe; }
        button { background-color: #7c3aed; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #6d28d9; }
        a { text-decoration: none; color: #5b21b6; }
        #message { margin-top: 10px; color: green; font-weight: bold; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<h1>Create Task</h1>

<form id="taskForm">
    <label>Title</label>
    <input type="text" name="title" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <label>
        <input type="checkbox" name="is_completed" value="1">
        Completed
    </label>

    <br><br>
    <button type="submit">Save Task</button>
</form>

<p id="message"></p>

<br>
<a href="/tasks">Back to Tasks</a>

<script>
document.getElementById('taskForm').addEventListener('submit', function(e) {
    e.preventDefault(); // prevent page reload

    let form = e.target;
    let data = new FormData(form);

    fetch('/tasks', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: data
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('message').innerText = 'Task saved successfully!';
        form.reset(); // clear form
    })
    .catch(error => {
        document.getElementById('message').innerText = 'Error saving task!';
        console.error(error);
    });
});
</script>

</body>
</html>