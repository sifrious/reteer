<x-app-layout>
    <div class="flex">
        <div id="col-right" class=" w-1/4 flex flex-column flex-wrap">
            <button class="border-2 border-black bg-white p-3 text-2xl rounded-lg font-bold m-auto">
                Volunteer Now
            </button>
        </div>
        <div id='col-left' class=" w-3/4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">

                <h1 class="w-full text-2xl font-bold pl-10 pb-2 pt-4">
                    @if ($task->name != '')
                        Task: {{ $task->name }}
                    @endif
                </h1>
                <div class="pl-10 hidden">
                    @if ($task->volunteer !== null)
                        Assigned to {{ $task->volunteer->name }}
                    @else
                        <span class="text-bold text-lg text-red-700">We need help with this!</span>
                    @endif
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-4/5 p-4 ml-0 m-auto">
                    <div class="grid grid-cols-[max-content_1fr] gap-3 w-full">
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
                        @if ($task->volunteer !== null)
                            <div id="grid-volunteer-label" class="text-right">
                                Assigned to:
                            </div>
                            <div id="grid-volunteer-value  font-bold">
                                {{ $task->volunteer->name }}
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
                                Start Time:
                            </div>
                            <div id="grid-start_time-value">
                                {{ $task->start_time }}
                            </div>
                        @endif
                        {{-- Task --}}
                        @if ($task->client_address != '')
                            <div id="grid-address-label" class="text-right">
                                Client Address:
                            </div>
                            <div id="grid-addresss-value">
                                {{ $task->client_address }}
                            </div>
                        @endif
                        {{-- Task --}}
                        @if ($task->contact_information != '')
                            <div id="grid-destination-label" class="text-right">
                                Destination:
                            </div>
                            <div id="grid-destination-value">
                                {{ $task->contact_information }}
                            </div>
                        @endif
                    </div>
                </div>
                <div id="author" class="w-full pl-10">
                    <small>
                        Uploaded by {{ $task->author }} via
                        @if ($task->sheets_created_at != '')
                            Google Sheets at {{ $task->sheets_created_at }}
                        @else
                            this website at {{ $task->created_at }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
</x-app-layout>
