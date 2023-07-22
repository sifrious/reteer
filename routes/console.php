<?php

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\Spreadsheet;
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
    $client->setApplicationName('reteer-app');
    $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
    $client->setAuthConfig('credentials.json');

    $spreadsheet = new Sheets($client);
    $spreadsheetValues = $spreadsheet->spreadsheets_values;
    
    $rawData = $spreadsheetValues->get('1kFZ2P8MTvc6pMOEc84-fQXtGMMvdBZZhKm1g-F87wnI', 'Logs')->getValues();
    $data = collect($rawData)->skip(2)->map(function (array $item) {
        return $item[6];
    })->dd(); // remove header rows
});
