<x-app-layout>
    <div class="flex-grow lg:flex">
        <x-repo-sidebar :repository="$repository"/>

        <main class="flex-1 p-4">{{ $slot }}</main>
    </div>
</x-app-layout>
