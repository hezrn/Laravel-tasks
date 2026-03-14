<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <style>
        body { font-family: Arial; background-color: #f5f3ff; padding: 20px; }
        h1 { color: #5b21b6; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; border-radius: 4px; border: 1px solid #d8b4fe; }
        button { background-color: #7c3aed; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #6d28d9; }
        a { text-decoration: none; color: #5b21b6; }
    </style>
</head>
<body>

<h1>Edit Task</h1>

<form action="/tasks/{{ $task->id }}" method="POST">
    @csrf
    @method('PUT')
    <label>Title</label>
    <input type="text" name="title" value="{{ $task->title }}" required>

    <label>Description</label>
    <textarea name="description">{{ $task->description }}</textarea>

    <label>
        <input type="checkbox" name="is_completed" value="1" @if($task->is_completed) checked @endif>
        Completed
    </label>

    <br><br>
    <button type="submit">Update Task</button>
</form>

<br>
<a href="/tasks">Back to Tasks</a>

</body>
</html>