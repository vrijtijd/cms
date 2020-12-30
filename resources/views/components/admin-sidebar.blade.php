<div class="flex flex-col flex-grow border-r border-gray-200 pt-2 pb-4 bg-white overflow-y-auto">
  <div class="flex-grow flex flex-col">
    <nav class="flex-1 px-2 bg-white space-y-1" aria-label="Sidebar">
    <x-sidebar-link icon="cloud" href="{{ route('admin.repositories.index') }}">
        Repositories
    </x-sidebar-link>
    <x-sidebar-link icon="user" href="#">
        Users
    </x-sidebar-link>
    <x-sidebar-link icon="user-group" href="#">
        Teams
    </x-sidebar-link>
    </nav>
  </div>
</div>
