<?php

use App\Models\User;
use App\Models\Task;

use function Pest\Laravel\{get};

// expect 200 routes
it('gives back successful response for the home page', function () {
    get(route('home'))->assertStatus(200);
});
