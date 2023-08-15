<?php

namespace App\Models;

use App\SheetsAPI\SheetsImport;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class TaskSushi extends Model
{
    use Sushi;

    public function getRows()
    {
        $import = new SheetsImport(env('GOOGLE_SHEET_NAME_TASKS'));
        $header = $import->getSheetHeader();
        return collect($import->getCurrentSheetValues())
            ->map(function ($taskValues) use ($header) {
                $newArray = array_fill(count($taskValues), (count($header) - count($taskValues)), null);
                $taskArray = array_combine($header, array_merge($taskValues, $newArray));
                return dump($taskArray);
            });
    }
}
