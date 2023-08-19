<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
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
    { // this is literally a guess
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    public function edit(Request $request, Task $task)
    {
        // $userId = Auth::user()->id;
        // $taskId = $task->id;
        return view('tasks.update');
    }

    public function update(Request $request, Task $task)
    {
        return 'hello world';
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

        $task_json = $task->toJson(); // create json object for api call

        return redirect('tasks');
    }
}
