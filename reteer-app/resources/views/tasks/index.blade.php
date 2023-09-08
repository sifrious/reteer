<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if ($count === 0)
                    {{ __('Tasks') }}
                @else
                    {{ __("There are $count unassigned tasks") }}
                @endif
            </h2>
            <a href="{{ route('tasks.create') }}"
                class="px-6 py-2 rounded border-2 border-black hover:bg-orange-200 font-bold">
                {{ __('Create Task') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="text-gray-900 text-2xl">
                {{ __('Upcoming Unassigned Tasks') }}
            </div>
            {{-- @foreach ($tasks as $task)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-gray-900">
                        <button data-expand="expandable-task-{{ $task->id }}"
                            class="hover:bg-slate-200 block w-full text-left p-6" aria-expanded="false"
                            aria-controls="expandable-task-{{ $task->id }}">
                            <span class="block">
                                @if ($task->start_date != '')
                                    <span>{{ $task->start_date }}</span>
                                    @if ($task->start_time != '')
                                        <span>@</span>
                                        <span>{{ $task->start_time }}</span>
                                    @endif
                                @endif
                            </span>
                            <span class="block">
                                {{ $task->task_description }}
                            </span>
                        </button>
                        <div id="expandable-task-{{ $task->id }}" class="border-t hidden p-6">
                            <div id="client-section">
                                <span>Client:</span>
                                {{ $task->client }}
                            </div>
                            <div id="volunteer-section">
                                <span>Volunteer:</span>
                                {{ $task->volunteer }}
                            </div>
                            <div id="location-section">
                                <div id="location-address-section">
                                    <span>Address:</span>
                                    {{ $task->address }}
                                </div>
                                <div>
                                    <span>Destination:</span>
                                    {{ $task->destination }}
                                </div>
                                <span>
                            </div>
                            <div id="author">
                                <small>
                                    Uploaded by {{ $task->author }} via
                                    @if ($task->sheets_created_at != '')
                                        Google Sheets at {{ $task->sheets_created_at }}
                                    @else
                                        this website at {{ $task->created_at }}
                                    @endif
                                </small>
                            </div>
                            <div class="px-6 py-2 ">
                                <a href="/tasks/{{ $task->id }}"
                                    class="text-white bg-cyan-500 mt-4 px-6 py-2 rounded font-bold">
                                    Show Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}
        </div>
    </div>

</x-app-layout>
