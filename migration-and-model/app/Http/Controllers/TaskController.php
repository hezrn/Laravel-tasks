<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
{
    $data = $request->all();
    $data['is_completed'] = $request->has('is_completed') ? true : false;
    $task = Task::create($data);
    return response()->json(['success'=>true, 'task'=>$task]);
}

public function update(Request $request, Task $task)
{
    $data = $request->all();
    $data['is_completed'] = $request->has('is_completed') ? true : false;
    $task->update($data);
    return response()->json(['success'=>true, 'task'=>$task]);
}

public function destroy(Task $task)
{
    $task->delete();
    return response()->json(['success'=>true]);
}

public function show(Task $task)
{
    return response()->json(['task'=>$task]);
}
}