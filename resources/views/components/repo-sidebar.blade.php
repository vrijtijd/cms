<div class="flex flex-col flex-grow border-r border-gray-200 pt-2 pb-4 bg-white overflow-y-auto">
    <div class="flex-grow flex flex-col">
        <nav class="flex-1 px-2 bg-white space-y-1" aria-label="Sidebar">
            @foreach ($archetypes as $archetype)
                <x-sidebar-link
                    icon="document-text"
                    href="{{ route('repositories.content.index', [$repository->id, Str::slug($archetype)]) }}"
                >
                    {{ $archetype }}
                </x-sidebar-link>
            @endforeach
            <x-sidebar-link
                icon="eye"
                href="{{ route('repositories.preview', [$repository->id]) }}"
                target="_blank"
            >
                Preview
            </x-sidebar-link>
            <x-sidebar-link
                icon="cloud-upload"
                href="{{ route('repositories.publish', [$repository->id]) }}"
            >
                Publish
            </x-sidebar-link>
        </nav>
    </div>
</div>
