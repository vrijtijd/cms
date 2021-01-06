<x-sidebar>
    <x-sidebar-link icon="cloud" href="{{ route('admin.repositories.index') }}">
        Repositories
    </x-sidebar-link>
    <x-sidebar-link icon="user" href="{{ route('admin.users.index') }}">
        Users
    </x-sidebar-link>
    <x-sidebar-link icon="user-group" href="{{ route('admin.teams.index') }}">
        Teams
    </x-sidebar-link>
</x-sidebar>
