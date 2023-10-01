<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Sushi\Sushi;
use App\Services\GoogleSheetsTasks;

class GoogleTask extends Model
{
    use Sushi;

    public function getRows()
    {
        $sushi_data = $this->fetchTasksSheet();
        $nRows = count($sushi_data) + 1;
        return array_map(function ($i, $sushi_values) use ($nRows) {
            return [
                "date_of_appointment" => $sushi_values["start_date"],
                "time" => $sushi_values["start_time"],
                "client_address" => $sushi_values["address"],
                "task_description" => $sushi_values["task_description"],
                "destination" => $sushi_values["destination"],
                "task_hours" => $sushi_values["hours"],
                "task_mileage" => $sushi_values["mileage"],
                "status" => $sushi_values["status"],
                "contact_information" => $sushi_values["contact_information"],
                "id_-_do_not_edit" => $sushi_values["sheets_id"],
                "row_number" => $sushi_values["sheets_row"],
                "actual_row" => $nRows - $i,
            ];
        }, array_keys($sushi_data), $sushi_data);
    }

    public function fetchTasksSheet()
    {
        $googleTasksSheet = new GoogleSheetsTasks();
        return $googleTasksSheet->tasks;
    }
}
