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

Artisan::command('app:get-sheet', function () {
    $client = new Client();
    $client->setApplicationName('reteer-app');
    $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
    $client->setAuthConfig('credentials.json');

    $spreadsheet = new Sheets($client);
    $spreadsheetValues = $spreadsheet->spreadsheets_values;
    
    $rawData = $spreadsheetValues->get('1kFZ2P8MTvc6pMOEc84-fQXtGMMvdBZZhKm1g-F87wnI', 'Logs')->getValues();

    Task::truncate();

    $header = collect($rawData[1])
        ->map(fn (string $item) => str($item)->lower()->replace(["(", ")", "*"], '')->replace([" ", "\n", "__"], "_")->toString());
    $data = collect($rawData)
        ->skip(2)
        ->map(fn (array $item) => $item[6] ?? '')
        ->each(function (string $taskName) { //commit to db
            Task::create([
                'name' => $taskName,
                'public' => false,
            ]);
        });
});

Artisan::command('app:test', function () {
    return null;
});