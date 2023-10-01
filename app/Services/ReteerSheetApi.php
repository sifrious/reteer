<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ReteerSheetApi
{
    public $rawData;
    public $sheetName;
    public $configuration;
    public $fetchResults;

    public function __construct(String $sheetConfig)
    {
        $this->rawData = $this->getSheet($sheetConfig);
        $this->sheetName = null;
        $this->configuration = null;
        $this->fetchResults = null;
    }

    private function getSheet(String $sheetConfig)
    {
        $this->sheetName = config($sheetConfig);

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

    private function getAssociatedDataArray()
    {
        $googleSheetDataArray = $this->configuration;
        $associatedData = [];
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
        $this->configuration["associatedData"] = $associatedData;
        return $associatedData;
    }

    private function getExpandedDataArray()
    {
        $associatedData = $this->configuration["associatedData"];
        $expandedDataArray = [];
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
        $this->fetchResults = $expandedDataArray;
        return $expandedDataArray;
    }

    public function convertSheet()
    {
        $this->getAssociatedDataArray();
        $this->getExpandedDataArray();
        return $this->fetchResults;
    }
}
