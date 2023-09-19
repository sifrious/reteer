@props(['tasks', 'user'])
<x-app-layout>
    {{ $user->name }}
    <x-tasks-list-user :tasks="$tasks"></x-tasks-list-user>
</x-app-layout>
