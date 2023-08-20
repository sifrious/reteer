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

    'id' => [
        'spreadsheet' => env('GOOGLE_SHEETS_ID'),
        'script' => env('GOOGLE_SCRIPT_ID')
    ],
    'names' => [
        'tasks' => env('GOOGLE_SHEET_NAME_TASKS'),
        'addresses' => env('GOOGLE_SHEET_NAME_ADDRESSES'),
        'contacts' => env('GOOGLE_SHEET_NAME_CONTACTS'),
        'volunteers' => env('GOOGLE_SHEET_NAME_VOLUNTEERS'),
    ],
    'url' => [
        'ss' => env('GOOGLE_DEPLOYMENT_ENDPOINT_URL'),
    ],
    'config' => env('GOOGLE_CREDENTIALS'),
];
