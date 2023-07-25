<?php

namespace App\Console\Commands;

use Google\Client;
use App\Models\Task;
use Google\Service\Sheets;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;

class GetSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return values from google sheet through API call';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $client = new Client();
        $client->setApplicationName('reteer-app');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig('credentials.json');

        $spreadsheet = new Sheets($client);
        $spreadsheetValues = $spreadsheet->spreadsheets_values;
        
        $rawData = $spreadsheetValues->get(config('services.sheets.document_id'), config('services.sheets.sheet_name'))->getValues();

        Task::truncate();

        $header = Arr::map($rawData[1], function (string $item) {
            return str($item)->lower()
                ->replace(["(", ")", "*"], '')
                ->replace([" ", "\n", "__"], "_")
                ->toString();
        });
            
        $data = collect($rawData)
            ->skip(2)
            ->map(fn (array $item) => $item[6] ?? '')
            ->each(function (string $taskName) { //commit to db
                Task::create([
                    'name' => $taskName,
                    'public' => false,
                ]);
            });
    }
}

/*
Artisan::command('app:get-sheet', function () {
    
});
*/
