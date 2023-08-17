<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST">
                    @csrf
                    <div class="p-1 text-gray-900">
                        <label for="start_date">Enter Date:</label>
                        <input id="start_date" value="" type="date" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="start_time">Enter the time the appointment will start:</label>
                        <input id="start_time" value="" type="time" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="name">Enter a name for the event that will help you remember</label>
                        <input id="name" value="" type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="description">Enter the task description **Required</label>
                        <input required id="description" value="" type="text" />
                    </div>
                    {{-- Select from existing clients --}}
                    <div class="p-1 text-gray-900">
                        <label for="client">Enter the client this task will assist</label>
                        <input id="client" value="" type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="address">Enter client pickup address</label>
                        <input id="address" value="" type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="destination">Enter task destination address</label>
                        <input id="destination" value="" type="text" />
                    </div>
                    <div class="p-1 text-gray-900">
                        <label for="contact_information">Add any contact information a
                            volunteer may need for this task</label>
                        <input id="contact_information" value="" type="text" />
                    </div>
                    <input type="submit" value="Save Task" />
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
