<x-admin-layout>
    <h1 class="text-3xl font-bold">Users</h1>

    <x-users.create-form :teams="$teams" :roles="$roles" class="mt-5"/>

    <div class="mt-3">
        <x-users.table :users="$users"/>
    </div>
</x-admin-layout>
