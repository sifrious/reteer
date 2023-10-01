<?php

namespace App\Services;

use App\Models\Task;
use App\Models\GoogleTask;
use Exception;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class GoogleSheetsTasks
{
    private $upcomingTasks;
    private $previousTasks;
    public $tasks;

    public function __construct()
    {
        $this->upcomingTasks = null;
        // $this->upcomingTasks = $this->returnUpcomingTasksSheet()
        $this->previousTasks = null;
        // $this->previousTasks = $this->returnPreviousTasksSheet();
        $this->tasks = $this->returnUpcomingTasksSheet();
    }

    private function getSheet(String $sheetConfig)
    {
        $client = new Client();
        $client->setApplicationName('reteer-app');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig(base_path('credentials.json'));

        $spreadsheet = new Sheets($client);
        $spreadsheetValues = $spreadsheet->spreadsheets_values;

        $rawData = $spreadsheetValues->get(config('sheets.id'), config($sheetConfig))->getValues();
        $headerRow = array_shift($rawData);

        // 
        $header = Arr::map($headerRow, function (string $item) {
            return Str::lower(str_replace(["(", ")", "*"], '', str_replace([" ", "\n", "__"], "_", $item)));
        });

        // create named array of indexes to use for headers with the sheet
        $lookup = Arr::map($headerRow, function (string $item, $i) {
            return [$item => $i];
        });

        $rawData = array_reverse($rawData);
        $row_length = array_reduce($rawData, function ($longestCount, $row) {
            if (is_array($row)) {
                return max($longestCount, count($row));
            };
            return $longestCount;
        }, 0);
        $normalLengthData = array_map(function ($row) use ($row_length) {
            if (is_array($row)) {
                if (count($row) < $row_length) {
                    $padCount = $row_length - count($row);
                    return array_merge($row, array_fill(0, $padCount, ""));
                } else {
                    return $row;
                };
            } else {
                return array_fill(0, $row_length, null);
            };
        }, $rawData);

        return ['header' => $header, 'lookup' => $lookup, 'data' => $normalLengthData];
    }

    private function convertSheet(array $googleSheetDataArray)
    {
        $associatedData = [];
        $expandedDataArray = [];
        $i = 0;
        $j = 1;
        foreach ($googleSheetDataArray['data'] as $row) {
            $associatedData[$i][$j] =  array_map(function ($i, $cellValue) use ($googleSheetDataArray) {
                $column_title = $googleSheetDataArray['header'][$i];
                if (isset($googleSheetDataArray['switch'][$column_title])) {
                    $parameter_name = $googleSheetDataArray['switch'][$column_title];
                } else {
                    $parameter_name = null;
                };
                $value = $cellValue;
                if ($value === '') {
                    $value = null;
                }
                return [
                    'column_title' => $column_title,
                    'parameter_name' => $parameter_name,
                    'value' => $value,
                ];
                return null;
            }, array_keys($row), $row);
            $i += 1;
        };
        $googleSheetDataArray['associatedData'] = $associatedData;
        foreach ($associatedData as $row) {
            foreach ($row as $rowArray) {
                $newRecord = [];
                foreach ($rowArray as $cellArray) {
                    if (isset($cellArray['parameter_name']) && $cellArray['parameter_name'] !== null) {
                        $newRecord[$cellArray['parameter_name']] = $cellArray['value'];
                    };
                };
                if (count($newRecord) > 0) {
                    array_push($expandedDataArray, $newRecord);
                };
            };
        };
        $googleSheetDataArray['expandedDataArray'] = $expandedDataArray;
        return $googleSheetDataArray;
    }

    public function getUpcomingTasksSheet()
    {
        // get general sheet data
        $taskSheetResponse = $this->getSheet('sheets.names.tasks');
        // define correlations between google Task data and Task model
        $taskSheetResponse['switch'] = [
            "date_of_appointment" => "start_date",
            "time" => "start_time",
            "client_address" => "address",
            "task_description" => "task_description",
            "destination" => "destination",
            "task_hours" => "hours",
            "task_mileage" => "mileage",
            "status" => "status",
            "contact_information" => "contact_information",
            "id_-_do_not_edit" => "sheets_id",
            "row_number" => "sheets_row",
        ];
        // define Task model functions that need to be programmatically updated or generated
        $taskSheetResponse["generated"] = [
            'sheets_row' => null,
            'sheets_created_at' => null,
            'author' => null,
            'public' => null,
        ];
        return $taskSheetResponse;
    }

    public function returnUpcomingTasksSheet()
    {
        $currentTasks = $this->getUpcomingTasksSheet();
        $conversion = $this->convertSheet($currentTasks);
        return $conversion;
    }

    public function getPreviousTasksSheet()
    {
        $results = $this->getSheet('sheets.names.previous_tasks');
        return $results;
    }

    public function returnPreviousTasksSheet()
    {
        $previousTasks = $this->getPreviousTasksSheet();
        $conversion = $this->convertSheet($previousTasks);
        return $conversion;
    }

    public function getTaskBackup()
    {
        $results = $this->getSheet('sheets.names.backup');
        return $results;
    }

    public function updateTasksSheet(GoogleTask $googleTask)
    {
        return null; // TODO
    }
}
