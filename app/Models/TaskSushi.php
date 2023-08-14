<?php

namespace App\Models;

use App\SheetsAPI\SheetsImport;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class TaskSushi extends Model
{
    use Sushi;

    public function getAllTasks()
    {
        $import = new SheetsImport(env('GOOGLE_SHEET_NAME_TASKS'));
        return $this->currentSheetsValues = $import;
    }

    public function getRows()
    {
        return collect($this->getAllTasks())
            ->map(function ($taskValues) {
                $taskArray = array_combine($this->header, $taskValues);
                return $taskArray;
            });
    }
}
