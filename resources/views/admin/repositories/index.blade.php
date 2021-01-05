<x-admin-layout>
    <h1 class="text-3xl font-bold">Repositories</h1>

    <x-repositories.create-form :teams="$teams" class="mt-5"/>

    <div class="mt-3">
        <x-repositories.table :repositories="$repositories"/>
    </div>
</x-admin-layout>
