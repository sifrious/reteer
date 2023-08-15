<?php


namespace App\SheetsAPI; // <- important

use Google\Client;
use App\Models\Task;
use Google\Service\Sheets;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SheetsImport
{
    private $sheetName;
    private $rawSheetData;
    private $header;
    private $rowsArray;

    public function __construct($sheetName)
    {
        $this->sheetName = $sheetName;
        $this->rawSheetData = $this->importRawSheetData();
        $this->header = $this->setSheetHeader();
        $this->rowsArray = $this->setCurrentSheetValues();
    }

    public function importRawSheetData()
    {
        $client = new Client();
        $client->setApplicationName('reteer-app');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig('credentials.json');

        $spreadsheet = new Sheets($client);
        $spreadsheetValues = $spreadsheet->spreadsheets_values;
        $rawData = $spreadsheetValues->get(env('GOOGLE_SHEETS_ID'), env('GOOGLE_SHEET_NAME_TASKS'))->getValues();

        return $this->rawSheetData = $rawData;
    }

    public function setSheetHeader()
    {
        $rawData = $this->rawSheetData;
        $header = Arr::map($rawData[0], function (string $item) {
            return Str::lower(str_replace(["(", ")", "*"], '', str_replace([" ", "\n", "__"], "_", $item)));
        });
        return $header;
    }

    public function getSheetHeader()
    {
        return $this->header;
    }

    public function setCurrentSheetValues()
    {

        Task::truncate();

        return collect($this->rawSheetData)
            ->skip(2)
            ->toArray();
    }

    public function getCurrentSheetValues()
    {
        return $this->rowsArray;
    }
}
