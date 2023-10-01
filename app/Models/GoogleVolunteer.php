<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Sushi\Sushi;
use App\Services\GoogleSheetsVolunteers;

class GoogleVolunteer extends Model
{
    use Sushi;

    public $isSushi = true;

    public function getRows()
    {
        $sushi_data = $this->fetchTasksSheet();
        $nRows = count($sushi_data) + 1;
        return array_map(function ($i, $sushi_values) use ($nRows) {
            return [
                "id_-_do_not_edit" => $sushi_values["sheets_id"],
                "email_address" => $sushi_values["email"],
                "first_name" => $sushi_values["first_name"],
                "last_name" => $sushi_values["last_name"],
                "has_access_to_current_spreadsheet" => $sushi_values["spreadsheet"],
                "row_number" => $sushi_values["sheets_row"],
                "actual_row" => $nRows - $i,
            ];
        }, array_keys($sushi_data), $sushi_data);
    }

    public function fetchTasksSheet()
    {
        $googleTasksSheet = new GoogleSheetsVolunteers();
        return $googleTasksSheet->volunteers;
    }
}
