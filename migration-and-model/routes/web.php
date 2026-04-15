<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Show greeting on root and support optional name in the URL
Route::get('/', function () {
    return view('greet');
});

Route::get('/greet/{name?}', function ($name = null) {
    return view('greet', ['name' => $name]);
})->name('greet');

// Tasks
Route::resource('tasks', TaskController::class);

// Support direct greeting names on root like /John while preserving task routes.
Route::get('/{name}', function ($name) {
    return view('greet', ['name' => $name]);
})->where('name', '^(?!tasks$|greet$|storage$|up$).+$');