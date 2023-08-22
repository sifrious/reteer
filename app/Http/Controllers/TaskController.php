<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
        return view('tasks.update');
    }

    public function create(Request $request)
    {
        return view('tasks.create');
    }

    public function confirmCreate(Request $request, Task $task)
    {
        dump($task);
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
            $value_array
        ]]);

        $options = ['valueInputOption' => 'RAW'];

        $spreadsheetValues->append(config('sheets.id'), config('sheets.names.tasks'), $values, $options);
        // $spreadsheetValues->append(config('sheets.id'), config('sheets.names.backup'), $values, $options);

        // save log entry
        // $values_string = '["' . implode(',"', $value_array) . ']';
        // dump($values_string);
        // $log_values = new ValueRange(['values' => [
        //     [
        //         'web app',
        //         'Task Tracking for Sign Up',
        //         now(),
        //         'PLACEHOLDER',
        //         $values_string,
        //         $task->google_sheets_id,
        //     ],
        // ]]);

        // $spreadsheetValues->append(config('sheets.id'), config('sheets.names.log'), $log_values, $options);

        // dd($log_values);

        return redirect()->route('tasks.confirmCreate', $task);
    }
}
