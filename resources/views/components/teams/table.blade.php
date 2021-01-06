@props(['teams'])

<x-table>
    <x-slot name="headings">
        <x-th>Name</x-th>
        <x-th>Owner</x-th>
        <x-th>Members</x-th>
        <x-th><span class="sr-only">Edit</span></x-th>
    </x-slot>

    @foreach($teams as $team)
        <x-teams.table-row :team="$team"/>
    @endforeach
</x-table>
