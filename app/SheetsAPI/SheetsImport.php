<?php


namespace App\SheetsAPI\SheetsImport; // <- important

use Google\Client;
use App\Models\Task;
use Google\Service\Sheets;
use Illuminate\Support\Arr;

class SheetsImport
{
    /**
     * Execute the console command.
     */
    public function handleBatch()
    {
        $client = new Client();
        $client->setApplicationName('reteer-app');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig('credentials.json');

        $spreadsheet = new Sheets($client);
        $spreadsheetValues = $spreadsheet->spreadsheets_values;

        $rawData = $spreadsheetValues->get('1kFZ2P8MTvc6pMOEc84-fQXtGMMvdBZZhKm1g-F87wnI', 'Logs')->getValues();

        Task::truncate();

        // clean and store header rows in an array
        $header = Arr::map($rawData[1], function (string $item) {
            return str($item)->lower()
                ->replace(["(", ")", "*"], '')
                ->replace([" ", "\n", "__"], "_")
                ->toString();
        });

        // store data before it has been committed
        // $data = collect($rawData)
        //     ->skip(2)
        //     ->filter(function (array $row) {
        //         return $row[6] ?? '' != '';
        //     })
        //     ->each(function (array $taskInfo) {
        //         Task::create([
        //             'start_date' => $taskInfo[2],
        //             'start_time' => $taskInfo[3],
        //             'name' => $taskInfo[6],
        //             'public' => false,
        //         ]);
        //     });
    }
}
