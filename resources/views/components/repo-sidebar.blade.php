<x-sidebar>
    @foreach ($archetypes as $archetype)
        <x-sidebar-link
            icon="document-text"
            href="{{ route('repositories.content.index', [$repository->id, $archetype->getSlug()]) }}"
        >
            {{ $archetype->getName() }}
        </x-sidebar-link>
    @endforeach
    <x-sidebar-link
        icon="upload"
        href="{{ route('repositories.uploads.index', [$repository->id]) }}"
    >
        Uploads
    </x-sidebar-link>
    <x-sidebar-link
        icon="eye"
        href="{{ route('repositories.preview', [$repository->id]) }}"
        target="_blank"
    >
        Preview
    </x-sidebar-link>
    <x-sidebar-link
        icon="cloud-upload"
        href="{{ route('repositories.publish.form', [$repository->id]) }}"
    >
        Publish
        @if ($hasChanges)
            <x-icon-exclamation-circle class="text-vt-pink-400 h-6 w-6 ml-auto"/>
        @endif
    </x-sidebar-link>
</x-sidebar>
