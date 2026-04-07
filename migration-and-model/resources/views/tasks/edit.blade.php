<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>

```
<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>
```

</head>

<body class="bg-gradient-to-br from-black via-purple-950 to-gray-900 min-h-screen flex items-center justify-center text-white">

```
<div class="w-full max-w-lg bg-white/5 backdrop-blur-lg border border-purple-500 rounded-2xl p-6 shadow-xl">

    <!-- Title -->
    <h1 class="text-2xl font-bold text-purple-300 mb-5 text-center">
        ✏️ Edit Task
    </h1>

    <!-- Form -->
    <form action="/tasks/{{ $task->id }}" method="POST" class="grid gap-4">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label class="block mb-1 text-purple-300">Title</label>
            <input 
                type="text" 
                name="title" 
                value="{{ $task->title }}" 
                required
                class="w-full p-2 rounded-md bg-black/60 border border-purple-400 focus:ring-2 focus:ring-purple-500 outline-none">
        </div>

        <!-- Description -->
        <div>
            <label class="block mb-1 text-purple-300">Description</label>
            <textarea 
                name="description"
                class="w-full p-2 rounded-md bg-black/60 border border-purple-400 focus:ring-2 focus:ring-purple-500 outline-none">{{ $task->description }}</textarea>
        </div>

        <!-- Completed -->
        <label class="flex items-center gap-2">
            <input 
                type="checkbox" 
                name="is_completed" 
                value="1"
                class="accent-purple-500"
                @if($task->is_completed) checked @endif>
            Completed
        </label>

        <!-- Buttons -->
        <div class="flex gap-3 mt-2">
            <a href="/tasks"
               class="flex-1 text-center bg-gray-600 hover:bg-gray-700 transition py-2 rounded-md font-semibold">
                Cancel
            </a>

            <button 
                type="submit"
                class="flex-1 bg-green-600 hover:bg-green-700 transition py-2 rounded-md font-semibold">
                ✓ Update Task
            </button>
        </div>

    </form>
</div>
```

</body>
</html>
