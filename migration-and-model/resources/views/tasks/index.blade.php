<!DOCTYPE html>
<html>
<head>
<title>Tasks</title>
</head>

<body>

<h1>Task List</h1>

<a href="/tasks/create">Create Task</a>

<table border="1">

<tr>
<th>Title</th>
<th>Description</th>
<th>Status</th>
<th>Actions</th>
</tr>

@foreach($tasks as $task)

<tr>

<td>{{ $task->title }}</td>

<td>{{ $task->description }}</td>

<td>
@if($task->is_completed)
Completed
@else
Pending
@endif
</td>

<td>

<a href="/tasks/{{ $task->id }}/edit">Edit</a>

<form action="/tasks/{{ $task->id }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button type="submit">Delete</button>

</form>

</td>

</tr>

@endforeach

</table>

</body>
</html>