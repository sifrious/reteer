<?php

use App\Models\User;
use App\Models\Task;
use App\Models\Team;

use function Pest\Laravel\{get};

it('gives back successful redirect response for unauthenticated users for the tasks.display page', function () {
    get(route('tasks.display'))->assertStatus(302);
});

it('tasks.display can be accessed by an authenticated user', function () {
    // Arrange
    $user = User::factory()
        ->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )
        ->create();
    $tasks = Task::factory()->count(5)->create();

    // Act & Assert
    $this->actingAs($user)
        ->get(route('tasks.display', ['tasks' => $tasks, 'user' => $user]))
        ->assertOk();
});
