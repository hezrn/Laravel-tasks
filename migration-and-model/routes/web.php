<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// 1. Greet page for base URL '/'
Route::get('/', function () {
    // You can set a default name like 'Guest' or 'Hezreen'
    return view('greet', ['name' => 'Hezreen']);
});

// 2. Optional greet page with a name parameter
Route::get('/greet/{name}', function ($name) {
    return view('greet', ['name' => $name]);
});

// 3. Tasks CRUD routes
Route::resource('tasks', TaskController::class);