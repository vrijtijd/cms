@props(['repositories'])

<x-table>
    <x-slot name="headings">
        <x-th>Repository</x-th>
        <x-th>Git URL</x-th>
        <x-th>Team</x-th>
        <x-th><span class="sr-only">Edit</span></x-th>
    </x-slot>

    @foreach($repositories as $repo)
        <x-repositories.table-row :repository="$repo"/>
    @endforeach
</x-table>
