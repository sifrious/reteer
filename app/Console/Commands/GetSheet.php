<?php

namespace App\Console\Commands;

use Google\Client;
use App\Models\Task;
use Google\Service\Sheets;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

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

        $rawData = $spreadsheetValues->get(env('GOOGLE_SHEETS_ID'), env('GOOGLE_SHEET_NAME_TASKS'))->getValues();

        // Task::truncate();

        $header = Arr::map($rawData[0], function (string $item) {
            return Str::lower(str_replace(["(", ")", "*"], '', str_replace([" ", "\n", "__"], "_", $item)));
        });

        $stagedValues = collect($rawData)
            ->skip(2)
            ->map(function ($taskValues) use ($header) {
                $newArray = array_fill(count($taskValues), (count($header) - count($taskValues)), null);
                $taskArray = array_combine($header, array_merge($taskValues, $newArray));
                return $taskArray;
            })
            ->filter(function (array $row) {
                return $row['task_description'] ?? '' != '';
            })
            ->map(function ($taskValues, $i) {
                return [
                    'sheets_id' => $taskValues['id_-_do_not_edit'],
                    'sheets_row' => $i + 1,
                    'author' => substr($taskValues['id_-_do_not_edit'], -14),
                    'start_date' => $taskValues['date_of_appointment'],
                    'start_time' => $taskValues['date_of_appointment'],
                    'public' => false,
                    'client_address' => $taskValues['client_address'],
                    'task_description' => $taskValues['task_description'],
                    'destination' => $taskValues['destination'],
                    'volunteer' => $taskValues['volunteer_or_case_manager'],
                    'status' => $taskValues['status'],
                    'contact_information' => $taskValues['contact_information'],
                ];
            });

        Task::query()->upsert($stagedValues->all(), 'sheets_id', [
            'sheets_row',
            'author',
            'start_date',
            'start_time',
            'client_address',
            'task_description',
            'destination',
            'volunteer',
            'status',
            'contact_information',
        ]);
    }
}
