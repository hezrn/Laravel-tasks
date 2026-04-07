<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Advanced Task Manager</title>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gradient-to-br from-black via-purple-950 to-gray-900 min-h-screen text-white">

<div class="max-w-4xl mx-auto p-4">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-purple-400">Task Manager</h1>
        
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed top-5 right-5 bg-purple-600 px-4 py-1.5 rounded-md shadow-lg hidden"></div>

    <!-- Create Task Card -->
    <div id="createCard" class="bg-white/5 backdrop-blur-lg border border-purple-500 rounded-2xl p-4 mb-6 shadow-xl">
        <h2 class="text-lg font-semibold mb-3 text-purple-300">Create Task</h2>

        <form id="taskForm" class="grid gap-4">
            <input type="text" name="title" placeholder="Task title" required
                class="p-2 rounded-md bg-black/60 border border-purple-400 focus:ring-2 focus:ring-purple-500 outline-none">

            <textarea name="description" placeholder="Task description"
                class="p-2 rounded-md bg-black/60 border border-purple-400 focus:ring-2 focus:ring-purple-500 outline-none"></textarea>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_completed" class="accent-purple-500">
                Completed
            </label>

            <button class="bg-purple-600 hover:bg-purple-700 transition py-1.5 rounded-md font-semibold">
                ➕ Add Task
            </button>
        </form>
    </div>

    <!-- Edit Task Card (Hidden by default) -->
    <div id="editCard" class="bg-white/5 backdrop-blur-lg border border-purple-500 rounded-2xl p-4 mb-6 shadow-xl hidden">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-purple-300">Edit Task</h2>
            <button onclick="cancelEdit()" class="text-gray-400 hover:text-white">✕</button>
        </div>

        <form id="editForm" class="grid gap-4">
            <input type="text" id="editTitle" placeholder="Task title" required
                class="p-2 rounded-md bg-black/60 border border-purple-400 focus:ring-2 focus:ring-purple-500 outline-none">

            <textarea id="editDesc" placeholder="Task description"
                class="p-2 rounded-md bg-black/60 border border-purple-400 focus:ring-2 focus:ring-purple-500 outline-none"></textarea>

            <label class="flex items-center gap-2">
                <input type="checkbox" id="editCompleted" class="accent-purple-500">
                Completed
            </label>

            <div class="flex gap-2">
                <button type="button" onclick="cancelEdit()" class="flex-1 bg-gray-600 hover:bg-gray-700 transition py-1.5 rounded-md font-semibold">
                    Cancel
                </button>
                <button type="button" onclick="saveEdit()" class="flex-1 bg-green-600 hover:bg-green-700 transition py-1.5 rounded-md font-semibold">
                    ✓ Save
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/70 hidden flex items-center justify-center z-50">
        <div class="bg-gray-900 p-6 rounded-2xl w-full max-w-sm border border-red-500 mx-auto shadow-xl">
            <h2 class="text-xl font-semibold mb-4 text-red-400">Delete Task</h2>
            <p class="text-gray-300 mb-6">Are you sure you want to delete this task? This action cannot be undone.</p>
            
            <div class="flex gap-3">
                <button type="button" onclick="cancelDelete()" class="flex-1 bg-gray-600 hover:bg-gray-700 transition py-2 rounded-md font-semibold">
                    Cancel
                </button>
                <button type="button" onclick="confirmDelete()" class="flex-1 bg-red-600 hover:bg-red-700 transition py-2 rounded-md font-semibold">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white/5 backdrop-blur-lg border border-purple-500 rounded-2xl p-4 shadow-lg mt-4">
        <h2 class="text-lg font-semibold mb-3 text-purple-300">Tasks</h2>

        <div class="overflow-x-auto mt-2">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-purple-300 border-b border-purple-700">
                        <th class="p-2 text-center">Title</th>
                        <th class="p-2 text-center">Description</th>
                        <th class="p-2 text-center">Status</th>
                        <th class="p-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="tasksTable">

                @foreach($tasks as $task)
                <tr data-id="{{ $task->id }}" class="border-b border-purple-900 hover:bg-purple-900/30 transition">
                    <td class="title p-2 text-center">{{ $task->title }}</div>
                    </td>
                    <td class="description p-2 text-center">{{ $task->description }}</div>
                    </td>
                    <td class="status p-2 text-center">
                        @if($task->is_completed)
                        <span class="text-green-400">✔ Completed</span>
                        @else
                        <span class="text-yellow-400">⏳ Pending</span>
                        @endif
                    </div>
                    </td>
                    <td class="p-2">
                        <div class="flex items-center justify-center gap-2">
                        <button class="edit-btn bg-blue-500 hover:bg-blue-600 px-2.5 py-1 rounded-md text-sm">Edit</button>
                        <button class="delete-btn bg-red-500 hover:bg-red-600 px-2.5 py-1 rounded-md text-sm">Delete</button>
                    </div>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let currentId = null;
let deleteId = null;

function showToast(msg){
    let toast = document.getElementById('toast');
    toast.innerText = msg;
    toast.classList.remove('hidden');
    setTimeout(()=>toast.classList.add('hidden'),2000);
}

// Create
document.getElementById('taskForm').addEventListener('submit', function(e){
    e.preventDefault();
    let data = new FormData(this);

    fetch('/tasks', { method:'POST', headers:{'X-CSRF-TOKEN':csrfToken}, body:data })
    .then(res=>res.json())
    .then(()=> location.reload());
});

// Table actions
document.getElementById('tasksTable').addEventListener('click', function(e){
    let row = e.target.closest('tr');
    let id = row.dataset.id;

    if(e.target.classList.contains('delete-btn')){
        deleteId = id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    if(e.target.classList.contains('edit-btn')){
        currentId = id;
        // Show edit card and hide create card
        document.getElementById('createCard').classList.add('hidden');
        document.getElementById('editCard').classList.remove('hidden');
        
        // Fill in the edit form with current task data
        document.getElementById('editTitle').value = row.querySelector('.title').innerText;
        document.getElementById('editDesc').value = row.querySelector('.description').innerText;
        document.getElementById('editCompleted').checked = row.querySelector('.status').innerText.includes('Completed');
        
        // Scroll to top to show edit card
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

// Save Edit
function saveEdit(){
    let data = new FormData();
    data.append('title', document.getElementById('editTitle').value);
    data.append('description', document.getElementById('editDesc').value);
    data.append('is_completed', document.getElementById('editCompleted').checked ? 1:0);
    data.append('_method','PUT');

    fetch(`/tasks/${currentId}`,{ method:'POST', headers:{'X-CSRF-TOKEN':csrfToken}, body:data })
    .then(()=> location.reload());
}

function cancelEdit(){ 
    document.getElementById('createCard').classList.remove('hidden');
    document.getElementById('editCard').classList.add('hidden');
    currentId = null;
}

function confirmDelete(){
    fetch(`/tasks/${deleteId}`,{ method:'DELETE', headers:{'X-CSRF-TOKEN':csrfToken}})
    .then(()=>{ 
        document.querySelector(`tr[data-id="${deleteId}"]`).remove();
        showToast('Deleted!'); 
        cancelDelete();
    });
}

function cancelDelete(){
    document.getElementById('deleteModal').classList.add('hidden');
    deleteId = null;
}

</script>

</body>
</html>
