<?php

use App\Models\User;
use App\Models\Task;

use function Pest\Laravel\{get};

it('gives back successful redirect response for unauthenticated users for the tasks.show page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.show', ['task' => $task]))->assertStatus(302);
});
