@props(['tasks'])
@foreach ($tasks as $task)
    <div id="task-{{ $task->id }}-container"
        class="rounded-xl overflow-hidden bg-white border border-gray-200 w-full p-0">
        <x-tasks-task-row :task="$task"></x-tasks-task-row>
    </div>
@endforeach
