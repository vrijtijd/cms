<x-app-layout>
    <div class="flex-grow flex">
        <div class="flex w-64">
            <x-admin-sidebar/>
        </div>

        <main class="flex-1 p-4">{{ $slot }}</main>
    </div>
</x-app-layout>
