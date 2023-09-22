<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<x-app-layout>
    <div class="flex place-content-center w-full">
        {{-- <div id="col-right" class=" w-1/4 flex flex-column flex-wrap">
        </div> --}}
        <div id='col-left' class="p-3 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <h1 class="w-full text-2xl font-bold p-2">
                    Create New Task
                </h1>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 ml-0 m-auto w-full">
                    <form method="POST">
                        @csrf
                        <div class="grid grid-cols-4 gap-3 w-full sm:w-full">
                            <div class="col-span-4">
                                <div class="flex flex-col flex-nowrap">
                                    <div class="pb-0 mb-0">
                                        <label for="task_description" class="w-full">Description</label>
                                        <small>(required)</small>
                                    </div>
                                    <textarea required id="task_description" name="task_description"> </textarea>
                                </div>
                            </div>
                            <div class="text-right font-bold p-3 block"><label for="start_date">Date:</label>
                            </div>
                            <div class="block"><input name="start_date" id="start_date" value=""
                                    type="date" />
                            </div>
                            <div class="text-right font-bold p-3 block">
                                <label for="start_time">Time:</label>
                            </div>
                            <div class="block"><input name="start_time" id="start_time" value=""
                                    type="time" />
                            </div>
                            <div class="p-1 text-gray-900">
                                <label for="client"class="text-right font-bold p-3 block">Client: </label>
                            </div>
                            <div class="col-span-3"><input name="client" id="client" value=""
                                    type="text"class="w-full" />
                            </div>
                            <div class="p-1 text-gray-900">
                                <label for="client_address"class="text-right font-bold p-3 block">Address:</label>
                            </div>
                            <div class="col-span-3">
                                <input name="client_address" id="client_address" value=""
                                    type="text"class="w-full" />
                            </div>
                            <div class="p-1 text-gray-900">
                                <label for="destination" class="text-right font-bold p-3 block">Destination:</label>
                            </div>
                            <div class="col-span-3">
                                <input name="destination" id="destination" value=""
                                    type="text"class="w-full" />
                            </div>
                            <div class="p-1 text-gray-900">
                                <label for="contact_information" class="text-right font-bold p-3 block">Contact:<br>
                                    Information</label>
                            </div>
                            <div class="col-span-3">
                                <input name="contact_information" id="contact_information" value="" type="text"
                                    class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-column w-full place-content-start">
                            <div class="p-3 w-full block">
                                <label for="name">Enter a name for the task you can use to find it
                                    later.</label>
                                <small>(Optional)</small>
                            </div>
                            <input name="name" id="name" value="" type="text" class="w-3/5" />
                        </div>
                        <div class="w-full flex flex-row place-content-center">
                            <input class="border-2 border-black rounded-lg bg-white w-2/5 p-3 mt-8 m-2 text-xl"
                                type="submit" value="Save Task" />
                        </div>
                    </form>
                </div>
            </div>
</x-app-layout>
