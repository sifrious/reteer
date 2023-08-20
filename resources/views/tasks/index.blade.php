<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="text-white bg-blue-500 px-6 py-2 rounded font-bold">
                {{ __('Create Task') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mb-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                {{ __("There are {$count} Unassigned Tasks") }}
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="text-gray-900 text-2xl">
                {{ __('Upcoming Unassigned Tasks') }}
            </div>
            @foreach ($tasks as $task)
                <a href="{{ url('tasks/') . '/' . $task->id }}">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div>
                                @if ($task->start_date != '')
                                    <span>{{ $task->start_date }}</span>
                                    @if ($task->start_time != '')
                                        <span>@</span>
                                        <span>{{ $task->start_time }}</span>
                                    @endif
                                @endif
                            </div>
                            {{ $task->task_description }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
