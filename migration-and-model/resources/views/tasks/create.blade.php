<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-br from-black via-purple-950 to-gray-900 min-h-screen text-white">

<div class="max-w-3xl mx-auto p-6">
    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold text-purple-300">Create Task</h1>
            <p class="mt-2 text-sm text-gray-300">Keep the purple workflow moving with a new task.</p>
        </div>
        <a href="/tasks" class="inline-flex items-center gap-2 rounded-full border border-purple-500/70 bg-white/5 px-4 py-2 text-sm text-purple-200 transition hover:bg-white/10">
            ← Back to Tasks
        </a>
    </div>

    <div class="rounded-[2rem] bg-white/5 border border-purple-500/40 p-8 shadow-2xl shadow-purple-900/30 backdrop-blur-xl">
        <form id="taskForm" class="grid gap-6">
            <div>
                <label for="title" class="block text-sm font-semibold text-purple-200 mb-2">Title</label>
                <input id="title" name="title" type="text" required placeholder="Task title"
                    class="w-full rounded-2xl border border-purple-400/30 bg-slate-950/70 px-4 py-3 text-white outline-none ring-2 ring-transparent transition focus:border-purple-300 focus:ring-purple-500/40" />
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-purple-200 mb-2">Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Task description"
                    class="w-full rounded-2xl border border-purple-400/30 bg-slate-950/70 px-4 py-3 text-white outline-none ring-2 ring-transparent transition focus:border-purple-300 focus:ring-purple-500/40"></textarea>
            </div>

            <label class="flex items-center gap-3 text-sm text-gray-200">
                <input type="checkbox" name="is_completed" value="1" class="h-5 w-5 rounded border-purple-400/70 bg-slate-950 text-purple-500 accent-purple-500" />
                Mark as completed
            </label>

            <button type="submit" class="w-full rounded-2xl bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-purple-500/20 transition hover:bg-purple-700">
                Save Task
            </button>

            <p id="message" class="min-h-[1.5rem] text-sm font-semibold text-emerald-300"></p>
        </form>
    </div>
</div>

<script>
    document.getElementById('taskForm').addEventListener('submit', function(e) {
        e.preventDefault();

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
        .then(() => {
            document.getElementById('message').innerText = 'Task saved successfully!';
            form.reset();
        })
        .catch(error => {
            document.getElementById('message').innerText = 'Error saving task!';
            console.error(error);
        });
    });
</script>

</body>
</html>
