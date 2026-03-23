<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Handle BOTH /greet and /greet/
Route::get('/greet/{name?}', function ($name = null) {
    return view('greet', ['name' => $name]);
});

// Tasks
Route::resource('tasks', TaskController::class);