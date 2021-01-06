@props(['users'])

<x-table>
    <x-slot name="headings">
        <x-th>Name</x-th>
        <x-th>Teams</x-th>
        <x-th><span class="sr-only">Edit</span></x-th>
    </x-slot>

    @foreach($users as $user)
        <x-users.table-row :user="$user"/>
    @endforeach
</x-table>
