<x-app-layout>
    <div class="flex-grow lg:flex">
        {{ $sidebar }}

        <main class="flex-1 p-4">{{ $slot }}</main>
    </div>
</x-app-layout>
