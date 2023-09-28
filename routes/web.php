<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    if (!App::environment('production')) {
        // The environment is local
        Route::get(
            '/test', //Test Page
            [TaskController::class, 'test']
        );
    }
    //user dashboard
    Route::get(
        '/dashboard',
        [TaskController::class, 'board']
    )->name('tasks.board');
    // all tasks
    Route::get(
        '/tasks/user',
        [TaskController::class, 'display']
    )->name('tasks.display');
    Route::get(
        '/tasks',
        [TaskController::class, 'index']
    )->name('tasks.index');
    // view create form
    Route::get(
        '/tasks/new',
        [TaskController::class, 'create']
    )->name('tasks.create');
    Route::post(
        '/tasks/new',
        [TaskController::class, 'store']
    )->name('tasks.store');
    // confirm task has been posted from spreadsheet
    Route::get(
        '/tasks/{task}/new',
        [TaskController::class, 'confirmCreate']
    )->name('tasks.confirmCreate');
    Route::post(
        '/tasks/new',
        [TaskController::class, 'store']
    )->name('tasks.store');
    Route::get(
        '/tasks/{task}',
        [TaskController::class, 'show']
    )->name('tasks.show');
    // view edit form
    Route::get(
        '/tasks/{task}/edit',
        [TaskController::class, 'edit']
    )->name('tasks.edit');
    Route::get(
        '/tasks/{task}/update',
        [TaskController::class, 'confirmEdit']
    )->name('tasks.update');
    // update existing task
    Route::get(
        '/tasks/{task}/update/',
        [TaskController::class, 'confirmEditFromUrl']
    )->name('tasks.update');
});
