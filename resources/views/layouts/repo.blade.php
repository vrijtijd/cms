<x-sidebar-layout>
    <x-slot name="sidebar">
        <x-repo-sidebar :repository="$repository"/>
    </x-slot>

    {{ $slot }}
</x-sidebar-layout>
