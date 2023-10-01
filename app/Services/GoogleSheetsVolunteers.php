<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use \Sushi\Sushi;
use App\Models\GoogleVolunteer;

class GoogleSheetsVolunteers
{
    public $volunteers;

    public function __construct()
    {
        $this->volunteers = $this->returnVolunteersSheet();
    }

    private function getSheet(String $sheetConfig)
    {
        $apiInstance = new ReteerSheetApi($sheetConfig);
        return $apiInstance;
    }

    public function getVolunteerService()
    {
        // get general sheet data
        $volunteerSheetResponse = $this->getSheet('sheets.names.volunteers');
        $volunteerSheetResponse->configuration = $volunteerSheetResponse->rawData;
        // define correlations between google Volunteer data and Volunteer model
        $volunteerSheetResponse->configuration['switch'] = [
            "id_-_do_not_edit" => "sheets_id",
            "email_address" => "email",
            "first_name" => "first_name",
            "last_name" => "last_name",
            "has_access_to_current_spreadsheet" => "spreadsheet",
            "row_number" => "sheets_row",
        ];
        // define Volunteer model functions that need to be programmatically updated or generated
        $volunteerSheetResponse->configuration["generated"] = [
            'sheets_row' => null,
            'name' => null,
            'spreadsheet' => null,
        ];
        return $volunteerSheetResponse;
    }

    public function returnVolunteersSheet()
    {
        $sheetService = $this->getVolunteerService('sheets.names.volunteers');
        $sheetService->convertSheet();
        dump($sheetService);
        return $sheetService->fetchResults;
    }

    public function getVolunteerBackup()
    {
        $results = $this->getSheet('sheets.names.backup');
        return $results;
    }

    public function updateVolunteersSheet(GoogleVolunteer $googleVolunteer)
    {
        return null; // TODO
    }
}
