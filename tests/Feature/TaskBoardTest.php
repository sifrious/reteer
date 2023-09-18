<?php

use App\Models\User;
use App\Models\Task;
use App\Models\Team;

use function Pest\Laravel\{get};


it('gives back successful redirect response for unauthenticated users for the tasks.board page', function () {
    get(route('tasks.board'))->assertStatus(302);
});

it('returns 200 on GET request for authenticated user @ tasks.board', function () {
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
        ->get(route('tasks.board', ['task' => $task, 'user' => $user]))
        ->assertOk();
});
