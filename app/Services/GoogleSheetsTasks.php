<?php

namespace App\Services;

use App\Models\GoogleTask;

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
        $apiInstance = new ReteerSheetApi($sheetConfig);
        return $apiInstance;
    }

    private function convertSheet(ReteerSheetApi $reteerSheetApi)
    {
        dump($reteerSheetApi);
        return $reteerSheetApi->convertSheet();
    }

    public function getTasksService(string $sheetConfig)
    {
        // get general sheet data
        $taskSheetResponse = $this->getSheet($sheetConfig);
        $taskSheetResponse->configuration = $taskSheetResponse->rawData;
        // define correlations between google Task data and Task model
        $taskSheetResponse->configuration['switch'] = [
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
        $taskSheetResponse->configuration["generated"] = [
            'sheets_row' => null,
            'sheets_created_at' => null,
            'author' => null,
            'public' => null,
        ];
        return $taskSheetResponse;
    }

    public function returnUpcomingTasksSheet()
    {
        $sheetService = $this->getTasksService('sheets.names.tasks');
        $sheetService->convertSheet();
        return $sheetService->fetchResults;
    }

    public function getPreviousTasksSheet()
    {
        $results = $this->getSheet('sheets.names.previous_tasks');
        return $results;
    }

    public function returnPreviousTasksSheet()
    {
        // $previousTasks = $this->getPreviousTasksSheet();
        // $conversion = $this->convertSheet($previousTasks);
        // return $conversion;
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
