<?php

namespace App\Services;

use App\Models\GoogleTask;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class ReteerRecord
{
    public $sushi;
    public $dbModel;
    private $complete;
    private $type;
    private $dbStatus;
    public $parameters;
    public $error;

    public function __construct(Model $input)
    {
        $this->sushi = null;
        $this->dbModel = null;
        $this->complete = false;
        $this->type = null;
        $this->error = true;
        $this->parameters = [];
        if (isset($input->isSushi)) {
            $this->type = $input->getTable();
            if ($input->isSushi === true) {
                $this->sushi = $input;
                $this->error = false;
                if ($this->type == 'google_tasks') {
                    $this->dbStatus = null;
                    $this->dbModel = $this->fillTaskSushi();
                }
            } else if ($input->isSushi == false) {
                $this->dbModel = $input;
                $this->error = false;
            };
        };
    }

    public function generateSheetsId()
    {
        $timestring = Carbon::now()->format('mdYhis');
        $carbonType = gettype(Carbon::now());
        dump("btw the carbon type is $carbonType");
        return "appDefault" . $timestring;
    }

    public function fillTaskSushi()
    {
        // "actual_row" => 8
        dump("in fillTaskSushi");
        dump($this->sushi);
        $sushiArray = $this->sushi->getAttributes();
        $this->parameters["sushi"] = array_keys($sushiArray);
        try {
            if ($this->sushi->sheets_id === null) {
                $sheets_id = $this->generateSheetsId();
                $this->sushi->sheets_id = $sheets_id;
                $this->parameters["sushi"]["sheets_id"] = $sheets_id;
            } else {
                dump("sheets id is not null it is ");
                dump($this->sushi->sheets_id);
            };
        } catch (Exception $e) {
            dump($e);
        }
        return null;
    }
}
