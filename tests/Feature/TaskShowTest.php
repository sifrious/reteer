<?php

use App\Models\User;
use App\Models\Task;
use App\Models\Team;

use function Pest\Laravel\{get};

it('gives back successful redirect response for unauthenticated users for the tasks.show page', function () {
    $task = Task::factory()->create(['task_description' => 'Test Task 1', 'sheets_id' => 1, 'public' => false]);
    get(route('tasks.show', ['task' => $task]))->assertStatus(302);
});

it('returns 200 on GET request for authenticated user @ tasks.show', function () {
    // Arrange
    $user = User::factory()
        ->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )
        ->create();
    $task = Task::factory()->create();

    // Act & Assert
    $this->actingAs($user)
        ->get(route('tasks.show', ['task' => $task, 'user' => $user]))
        ->assertOk();
});
