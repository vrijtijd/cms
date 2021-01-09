<x-admin-layout>
    <h1 class="text-3xl font-bold">{{ $repository->name }}</h1>

    <x-repositories.form :teams="$teams" :repository="$repository" class="mt-5"/>
</x-admin-layout>
