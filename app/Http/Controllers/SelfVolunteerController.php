<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Volunteer;

class SelfVolunteerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Task $task)
    {
        $user = $request->user();
        $volunteer = $user->volunteer;
        if ($volunteer === null) {
            $volunteer = Volunteer::create(
                [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                ]
            );
        };
        if ($task->volunteer_id === null) {
            $task->volunteer_id = $volunteer->id;
        } else {
            $task->volunteer_id = null;
        };
        $task->save();
        return redirect("tasks/$task->id");
    }
}
