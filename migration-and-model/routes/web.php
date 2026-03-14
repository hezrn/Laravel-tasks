<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/greet/{name}', function ($name) {
    return view('greet', ['name' => $name]);
});

Route::resource('tasks', TaskController::class);