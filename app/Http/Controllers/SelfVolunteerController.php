<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class SelfVolunteerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Task $task)
    {
        $volunteer = $request->user()->volunteer;
        $taskVolunteer = $task->volunteer;
        if ($taskVolunteer === null) {
            $task->volunteer_id = $volunteer->id;
        } else {
            $task->volunteer_id = null;
        }
        $task->save();
        return redirect("tasks/$task->id");
    }
}
