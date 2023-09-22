<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    @if ($status === 'success')
        <div class="py-12">
            <h1 class="w-full text-center text-2xl font-bold pb-4">Successfully Created Task
                @if ($task->name != '')
                    {{ $task->name }}
                @else
                    #{{ $task->id }}
                @endif
            </h1>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-4/5 p-4 m-auto">
                    <div class="grid grid-cols-2 gap-3 w-full">
                        {{-- Task Description Row --}}
                        @if ($task->task_description != '')
                            <div id="grid-description-label" class="text-right">
                                Description:
                            </div>
                            <div id="grid-description-value font-bold">
                                {{ $task->task_description }}
                            </div>
                        @else
                            A task description is required and one has not been found for this entry.
                            This message indicates a error, please contact your site administrator at
                            <a href="mailto:admin@reteer.org">admin@reteer.org</a>
                        @endif
                        {{-- Task --}}
                        @if ($task->volunteer != '')
                            <div id="grid-volunteer-label" class="text-right">
                                Assigned to:
                            </div>
                            <div id="grid-volunteer-value  font-bold">
                                {{ $task->volunteer }}
                            </div>
                        @endif
                        {{-- Task --}}
                        @if ($task->start_date != '')
                            <div id="grid-start-date-label" class="text-right">
                                Start Date:
                            </div>
                            <div id="grid-start-date-value">
                                {{ $task->start_date }}
                            </div>
                        @endif
                        {{-- Task --}}
                        @if ($task->start_time != '')
                            <div id="grid-start_time-label" class="text-right">
                                Start Time
                            </div>
                            <div id="grid-start_time-value">
                                {{ $task->start_time }}
                            </div>
                        @endif
                        {{-- Task --}}
                        @if ($task->client_address != '')
                            <div id="grid-address-label" class="text-right">
                                Client Address
                            </div>
                            <div id="grid-addresss-value">
                                {{ $task->client_address }}
                            </div>
                        @endif
                        {{-- Task --}}
                        @if ($task->contact_information != '')
                            <div id="grid-destination-label" class="text-right">
                                Destination
                            </div>
                            <div id="grid-destination-value">
                                {{ $task->contact_information }}
                            </div>
                        @endif
                    </div>
                </div>
                <div id="author" class="w-full text-center">
                    <small>
                        Uploaded by {{ $task->author }} via
                        @if ($task->sheets_created_at != '')
                            Google Sheets at {{ $task->sheets_created_at }}
                        @else
                            this website at {{ $task->created_at }}
                        @endif
                    </small>
                </div>
            @else
                <div>
                    An error occurred and the task could not be created. Please contact your system
                    administrator at
                    <a href="mailto:admin@reteer.org">admin@reteer.org</a>.
                </div>
            </div>
        </div>
        </div>
    @endif

    <div class="p-6 text-gray-900 w-full flex flex-row flex-wrap gap-4 place-content-center">
        <a href="{{ url("/tasks/{$task->id}") }}">
            <div class="border-2 border-black rounded-md p-2 text-xl bg-white">
                View Task Details
            </div>
        </a>
        <a href="{{ url('/tasks/show') }}">
            <div class="border-2 border-black rounded-md p-2 text-xl bg-white">
                View All Tasks
            </div>
        </a>
    </div>
</x-app-layout>
