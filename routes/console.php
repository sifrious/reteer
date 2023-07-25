<?php

use App\Models\Task;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\Spreadsheet;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Collection;

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

Artisan::command('app:test', function () {
    return null;
});