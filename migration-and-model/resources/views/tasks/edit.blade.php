<!DOCTYPE html>
<html>
<head>
<title>Edit Task</title>
</head>

<body>

<h1>Edit Task</h1>

<form action="/tasks/{{ $task->id }}" method="POST">

@csrf
@method('PUT')

Title
<input type="text" name="title" value="{{ $task->title }}">

<br><br>

Description
<textarea name="description">{{ $task->description }}</textarea>

<br><br>

Completed
<input type="checkbox" name="is_completed" value="1"
@if($task->is_completed) checked @endif>

<br><br>

<button type="submit">Update</button>

</form>

</body>
</html>