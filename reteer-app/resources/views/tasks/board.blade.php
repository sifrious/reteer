<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if ($count_unassigned > 0)
                    {{ __('Tasks') }}
                @else
                    {{ __("There are $count_unassigned unassigned tasks") }}
                @endif
            </h2>
            <a href="{{ route('tasks.create') }}"
                class="px-6 py-2 rounded border-2 border-black hover:bg-orange-200 font-bold">
                {{ __('Create Task') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        @if ($unassigned)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <h1 class="font-serif text-gray-900 text-4xl mb-8">
                    {{ __('Upcoming Unassigned Tasks') }}
                </h1>
                <x-tasks-list :tasks="$unassigned"></x-tasks-list>
            </div>
        @endif
    </div>
</x-app-layout>
