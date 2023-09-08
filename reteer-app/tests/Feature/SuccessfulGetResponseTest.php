<?php

use Illuminate\Support\Facades\Route;

use function Pest\Laravel\{get};

it('gives back successful response for the home page', function () {
    get(route('home'))->assertStatus(200);
});
it('gives back successful response for the tasks.board page', function () {
    get(route('tasks.board'))->assertStatus(200);
});
it('gives back successful response for the tasks.display page', function () {
    get(route('tasks.display'))->assertStatus(200);
});
it('gives back successful response for the tasks.index page', function () {
    get(route('tasks.index'))->assertStatus(200);
});
it('gives back successful response for the tasks.create page', function () {
    get(route('tasks.create'))->assertStatus(200);
});
it('gives back successful response for the tasks.store page', function () {
    get(route('tasks.store'))->assertStatus(200);
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
