<?php

use App\Models\Task;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\Spreadsheet;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Collection;
use Google\Service\Sheets\ValueRange;

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

Artisan::command('app:post-new-sheet', function () {
    $client = new Client();
    $client->setApplicationName('reteer-app');
    $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
    $client->setAuthConfig(base_path('credentials.json'));

    $spreadsheet = new Sheets($client);
    $spreadsheetValues = $spreadsheet->spreadsheets_values;

    $values = new ValueRange(['values' => [
        ['value1', 'value2', 'value4'],
    ]]);
    $options = ['valueInputOption' => 'RAW'];

    $spreadsheetValues->append(config('sheets.id'), config('sheets.names.tasks'), $values, $options);
});

Artisan::command('app:post-update-cell', function () {
    $client = new Client();
    $client->setApplicationName('reteer-app');
    $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
    $client->setAuthConfig(base_path('credentials.json'));

    $spreadsheet = new Sheets($client);
    $spreadsheetValues = $spreadsheet->spreadsheets_values;

    $values = new ValueRange(['values' => [
        ['again'],
    ]]);
    $options = ['valueInputOption' => 'RAW'];

    $range = config('sheets.names.tasks') . '!A16:A16';

    $spreadsheetValues->update(config('sheets.id'), $range, $values, $options);
});
