<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
            @if ($task->name)
                > {{ $tasks->name }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST">
                    @csrf
                    <div>
                        <div class="p-1 text-gray-900">
                            <p>The task previously was scheduled to occur on {{ $task->start_date }} at
                                {{ $task->start_time }}</p>
                            <p>To change it, select a new date and time below. If you do not select a new date and time,
                                the
                                previously saved information will remain available.</p>
                            <label for="start_date" class="=w-2/5">Date:</label>
                            <input name="start_date" id="start_date" value="" type="date" />
                        </div>
                        <div class="p-1 text-gray-900">
                            <label for="start_time">Time:</label>
                            <input name="start_time" id="start_time" value="{{ $task->start_time }}" type="time" />
                        </div>
                    </div>
                    <p>
                        To add or change information, change it in the fields below. All fields that are not edited will
                        retain their values after the edit.

                    </p>
                    <div class="p-1 text-gray-900">
                        <label for="name">In-App Task Nickname</label>
                        <input name="name" id="name" value="{{ $task->name }}" type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="task_description">Description</label>
                        <input name="task_description" id="task_description" value="{{ $task->task_description }}"
                            type="text" />
                    </div>
                    {{-- Select from existing clients --}}
                    <div class="p-1 text-gray-900">
                        <label for="client">Client</label>
                        <input name="client" id="client" value="{{ $task->client }}" type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="client_address">Client Pickup Address</label>
                        <input name="client_address" id="client_address" value="{{ $task->client_address }}"
                            type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="destination">Task Destination Address</label>
                        <input name="destination" id="destination" value="{{ $task->destination }}" type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="contact_information">Contact Information</label>
                        <input name="contact_information" id="contact_information"
                            value="{{ $task->contact_information }}" type="text" />
                    </div>
                    <input type="submit" value="Save Task" />
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
