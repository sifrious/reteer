<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Sushi\Sushi;

class GoogleTask extends Model
{
    use Sushi;

    public $isSushi = true;

    public function getRows()
    {
        $sushi_data = $this->fetchTasksSheet();
        $nRows = count($sushi_data) + 1;
        return array_map(function ($i, $sushi_values) use ($nRows) {
            return [
                "start_date" => $sushi_values["start_date"],
                "start_time" => $sushi_values["start_time"],
                "address" => $sushi_values["address"],
                "task_description" => $sushi_values["task_description"],
                "destination" => $sushi_values["destination"],
                "hours" => $sushi_values["hours"],
                "mileage" => $sushi_values["mileage"],
                "status" => $sushi_values["status"],
                "contact_information" => $sushi_values["contact_information"],
                "sheets_id" => $sushi_values["sheets_id"],
                "sheets_row" => $sushi_values["sheets_row"],
                "actual_row" => $nRows - $i,
                "sheet_type" => 'upcoming', //TODO update when previous task import is working
            ];
        }, array_keys($sushi_data), $sushi_data);
    }

    // public function fetchTasksSheet()
    // {
    //     $googleTasksSheet = new GoogleSheetsTasks();
    //     return $googleTasksSheet->tasks;
    // }
}
