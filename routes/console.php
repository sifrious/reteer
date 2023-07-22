<?php

use Google\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:get-sheet', function () {
    $client = new Client();
    $client->setApplicationName("reteer-app");
    $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
    $client->setAuthConfig("credentials.json");
});