<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => Task::all(),
            'count' => Task::where('volunteer', '=', null)->count(),
        ]);
    }

    public function board(Request $request)
    {
        $tasks = Task::all()->sortByDesc('start_date')->sortByDesc('start_time');
        $dated = [];
        $dateless = [];
        $upcoming = [];
        $past = [];
        $unassigned = [];
        $assigned = [];
        $i = 0;
        foreach ($tasks as $task) {
            $now = strtotime(now());
            $date = strtotime($task->start_date);
            if ($date) {
                try {
                    if ($date > $now) {
                        array_push($upcoming, $task);
                    } else {
                        array_push($past, $task);
                    };
                    array_push($dated, $task);
                } catch (Exception $e) {
                    array_push($dated, $task);
                }
            } else {
                array_push($dateless, $task);
            }
            if ($task->status === 'Unassigned' || $task->status === 'Urgent') {
                array_push($unassigned, $task);
            } else {
                array_push($assigned, $task);
            }
        };
        return view('tasks.board', [
            'dated' => $dated,
            'dateless' => $dateless,
            'upcoming' => $upcoming,
            'past' => $past,
            'unassigned' => $unassigned,
            'assigned' => $assigned,
            'count_unassigned' => count($unassigned),
            'count_assigned' => count($assigned),
        ]);
    }

    public function show(Request $request, Task $task)
    {
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    public function edit(Request $request, Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function confirmEdit(Request $request, Task $task)
    {
        dump($task);
        return "saving task to google sheets";
    }

    public function update(Request $request, Task $task)
    {

        $task->update($request->only([
            'start_date',
            'start_time',
            'name',
            'task_description',
            'client_address',
            'destination',
            'contact_information',
            'volunteer',
        ]));
        return redirect("tasks/$task->id");
    }

    public function create(Request $request)
    {
        return view('tasks.create');
    }

    public function confirmCreate(Request $request, Task $task)
    {
        sleep(5);

        $client = new Client();
        $client->setApplicationName('reteer-app');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig(base_path('credentials.json'));

        $spreadsheet = new Sheets($client);
        $spreadsheetValues = $spreadsheet->spreadsheets_values;

        $rawData = $spreadsheetValues->get(config('sheets.id'), config('sheets.names.tasks'))->getValues();
        $sheet_id = null;
        $google_sheets_id = 8;
        $google_sheets_row_number = 10;
        foreach ($rawData as $rawRow) {
            // dump("old array was ");
            // dump($rawRow);
            $row = array_merge($rawRow, array_fill(count($rawRow), 11 - count($rawRow), ""));
            // dump("new array is");
            // dump($row);
            try {
                if ($row[$google_sheets_id] == $task->sheets_id) {
                    try {
                        $sheet_id = $row[$google_sheets_row_number];
                        break;
                    } catch (Exception $e) {
                        dump("no row number value" . $e);
                    }
                }
            } catch (Exception $e) {
                dump("no sheet id value", $e);
            };
        };
        // dd($rawData);
        if ($sheet_id != null) {
            $task->sheets_row = $sheet_id;
            $task->save();
            return view('tasks.confirmnew', ['task' => $task, 'status' => 'success']);
        } else {
            return view('tasks.confirmnew', ['task' => null, 'status' => 'error']);
        };
        return "hello world - created task";
    }

    public function store(Request $request)
    {
        $task = Task::make($request->only([
            'start_date',
            'start_time',
            'name',
            'task_description',
            'client_address',
            'destination',
            'contact_information',
        ]));

        $handle = Str::before($request->user()->email, '@');
        $date = now()->format('mdYHis');

        $task->sheets_id = $handle . $date;
        $task->sheets_row = -1;
        $task->author = $request->user()->name;
        $task->public = true;
        $task->status = 'unassigned';

        $task->save();

        // save task to google drive
        $client = new Client();
        $client->setApplicationName('reteer-app');
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
        $client->setAuthConfig(base_path('credentials.json'));
        $task->action = 'create';


        $spreadsheet = new Sheets($client);
        $spreadsheetValues = $spreadsheet->spreadsheets_values;

        $values_array = [
            $task->start_date,
            $task->start_time,
            $task->client_address,
            $task->task_description,
            $task->destination,
            $task->volunteer,
            $task->status,
            $task->contact_information,
            $task->sheets_id,
            $task->author,
        ];
        $value_array = Arr::map($values_array, function ($value) {
            return $value ?? '';
        });
        $values = new ValueRange(['values' => [
            $value_array,

        ]]);

        $options = ['valueInputOption' => 'RAW'];

        $spreadsheetValues->append(config('sheets.id'), config('sheets.names.tasks'), $values, $options);
        //$spreadsheetValues->append(config('sheets.id'), config('sheets.names.backup'), $values, $options);

        // save log entry
        $values_string = '["' . implode(',"', $value_array) . ']';
        dump($values_string);
        $log_values = new ValueRange(['values' => [
            [
                'web app',
                'Task Tracking for Sign Up',
                now(),
                'PLACEHOLDER',
                $values_string,
                $task->sheets_id,
            ],
        ]]);

        $spreadsheetValues->append(config('sheets.id'), config('sheets.names.log'), $log_values, $options);

        return redirect()->route('tasks.confirmCreate', $task);
    }

    public function confirmStore(Request $request, Task $task)
    {
        $task_json = $task->toJson(); // create json object for api call

        dump($task_json);
        return view('tasks.confirmNew');
    }
}