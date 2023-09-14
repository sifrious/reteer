<?php

use function Pest\Laravel\{get};

it('gives back successful response for the home page', function () {

    get(route('home'))->assertStatus(200);
});
