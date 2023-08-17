<?php

use App\Models\Task;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/tasks');

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('/tasks/{task}', function (Task $task) {
        return view('tasks.show')->with('task', $task);
    });

    Route::get('/task/new', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/task/new', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('/task/{id}/edit', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
