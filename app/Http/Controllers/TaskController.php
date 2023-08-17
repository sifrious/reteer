<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        Task::create(request()->only([
            'name',
            'task_description',
            'start_time',
            'start_date',
            'client_address',
            'destination',
            'volunteer',
            'contact_information',
        ]));

        return redirect('tasks');
    }
}
