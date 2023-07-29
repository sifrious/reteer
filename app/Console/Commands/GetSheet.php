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
        $client = new Client();
        $client->setApplicationName('reteer-app');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig('credentials.json');

        $spreadsheet = new Sheets($client);
        $spreadsheetValues = $spreadsheet->spreadsheets_values;

        $rawData = $spreadsheetValues->get('1kFZ2P8MTvc6pMOEc84-fQXtGMMvdBZZhKm1g-F87wnI', 'Logs')->getValues();

        Task::truncate();

        collect($rawData)
            ->skip(2)
            ->filter(function (array $row) {
                return $row[6] ?? '' != '';
            })
            ->each(function (array $taskInfo) {
                Task::create([
                    'start_date' => $taskInfo[2],
                    'start_time' => $taskInfo[3],
                    'name' => $taskInfo[6],
                    'public' => false,
                ]);
            });
    }
}
