<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration of google spreadsheet ids and 
    |  sheet names.
    |
    */

    'id' => env('GOOGLE_SHEETS_ID'),
    'names' => [
        'tasks' => env('GOOGLE_SHEET_NAME_TASKS'),
        'backup' => env('GOOGLE_SHEET_NAME_TASKS_BACKUP'),
        'log' => env('GOOGLE_SHEET_NAME_LOGS'),
        'addresses' => env('GOOGLE_SHEET_NAME_ADDRESSES'),
        'contacts' => env('GOOGLE_SHEET_NAME_CONTACTS'),
        'volunteers' => env('GOOGLE_SHEET_NAME_VOLUNTEERS'),
    ],
    'url' => [
        'ss' => env('GOOGLE_DEPLOYMENT_ENDPOINT_URL'),
    ],
    'config' => env('GOOGLE_CREDENTIALS'),
];
