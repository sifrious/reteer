<?php

use App\Models\User;
use App\Models\Task;

use function Pest\Laravel\{get};

// expect 200 routes
it('gives back successful response for the home page', function () {
    get(route('home'))->assertStatus(200);
});
// expect 302 Routes
it('gives back successful redirect response for unauthenticated users for the tasks.board page', function () {
    get(route('tasks.board'))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.index page', function () {
    get(route('tasks.index'))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.create page', function () {
    get(route('tasks.create'))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.confirmCreate page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.confirmCreate', ['task' => $task]))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.show page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.show', ['task' => $task]))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.edit page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.edit', ['task' => $task]))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.update page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.update', ['task' => $task]))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.display page', function () {
    get(route('tasks.display'))->assertStatus(302);
});
it('gives back successful redirect response for unauthenticated users for the tasks.store page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.store', ['task' => $task]))->assertStatus(302);
});
it('gives back successful forbidden response for the tasks.confirmStore page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.confirmStore', ['task' => $task]))->assertStatus(405);
});
