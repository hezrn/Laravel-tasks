<!DOCTYPE html>
<html>
<head>
<title>Create Task</title>
</head>

<body>

<h1>Create Task</h1>

<form action="/tasks" method="POST">

@csrf

Title
<input type="text" name="title">

<br><br>

Description
<textarea name="description"></textarea>

<br><br>

Completed
<input type="checkbox" name="is_completed" value="1">

<br><br>

<button type="submit">Save</button>

</form>

</body>
</html>