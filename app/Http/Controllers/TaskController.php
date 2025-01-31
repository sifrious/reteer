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
            'count' => Task::where('volunteer_id', '=', null)->count(),
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

    public function display(Request $request)
    {
        $user = $request->user();
        $userTasks = Task::all(); // change this when assignment is working
        return view('tasks.display', ['tasks' => $userTasks, 'user' => $user]);
    }

    public function show(Request $request, Task $task)
    {
        return view('tasks.show', [
            'task' => $task,
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request, Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
        ]);
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
            'volunteer_id',
        ]));
        return redirect("tasks/$task->id");
    }

    public function confirmEdit(Request $request, Task $task)
    {
        // dump($task);
        return "saving task to google sheets";
    }

    public function confirmEditFromUrl(Request $request, Task $task)
    {
        return "edit from path";
    }

    public function create(Request $request)
    {
        return view('tasks.create');
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

//        $task->action = 'create';

        return redirect()->route('tasks.show', $task);
    }

    public function confirmStore(Request $request, Task $task)
    {
        $task_json = $task->toJson(); // create json object for api call
        return view('tasks.confirmNew');
    }

    public function confirmStoreFromUrl(Request $request, Task $task)
    {
        return "store from path";
    }

    public function test(Request $request)
    {
    }

    public function volunteer(Request $request, Task $task)
    {
        $volunteer = $request->user()->volunteer;
        $task->volunteer_id = $volunteer->id;
        $task->save();
        return redirect("tasks/$task->id");
    }
    public function unvolunteer(Request $request, Task $task)
    {
        $task->volunteer_id = null;
        $task->save();
        return redirect("tasks/$task->id");
    }
}
