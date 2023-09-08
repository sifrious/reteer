<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\{get};

// expect 302 Routes
it('gives back successful response for the tasks.board page', function () {
    get(route('tasks.board'))->assertStatus(302);
});
it('gives back successful response for the tasks.index page', function () {
    get(route('tasks.index'))->assertStatus(302);
});
it('gives back successful response for the tasks.create page', function () {
    get(route('tasks.create'))->assertStatus(302);
});
it('gives back successful response for the tasks.store page', function () {
    get(route('tasks.store'))->assertStatus(302);
});
// expect 200 routes
it('gives back successful response for the home page', function () {

    get(route('home'))->assertStatus(200);
});
// 200 routes with variables
it('gives back successful response for the tasks.display page', function () {
    // create tasks
    Task::factory()->create(['description' => 'Test Task 1']);
    Task::factory()->create(['description' => 'Test Task 2']);
    Task::factory()->create(['description' => 'Test Task 3']);
    get(route('tasks.display'))->assertSeeText(['Test Task 1', 'Test Task 2', 'Test Task 3']);
});
it('gives back successful response for the tasks.confirmCreate page', function () {
    get(route('tasks.confirmCreate'))->assertStatus(200);
});
it('gives back successful response for the tasks.confirmStore page', function () {
    get(route('tasks.confirmStore'))->assertStatus(200);
});
it('gives back successful response for the tasks.show page', function () {
    get(route('tasks.show'))->assertStatus(200);
});
it('gives back successful response for the tasks.edit page', function () {
    get(route('tasks.edit'))->assertStatus(200);
});
it('gives back successful response for the tasks.update page', function () {
    get(route('tasks.update'))->assertStatus(200);
});
