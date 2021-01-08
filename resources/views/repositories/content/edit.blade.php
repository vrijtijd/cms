@push('styles')
    <link rel="stylesheet" href="{{ mix('css/simplemde.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/content-editor.js') }}"></script>
@endpush

<x-repo-layout :repository="$repository">
    <div>
        <h3 class="text-lg leading-6 font-medium text-vt-darkGray-800">
            {{ $contentFile->getName() }}
        </h3>
    </div>

    @if (session('created'))
        <x-alert-banner class="mt-3">
            New
            <span class="italic">{{ Str::singular(strtolower($archetype->getName())) }}</span>
            created.
        </x-alert-banner>
    @elseif (session('updated'))
        <x-alert-banner class="mt-3">
            Changes to <span class="italic">{{ $contentFile->getName() }}</span> saved!
            @if ($canPreview)
                <a
                    href="{{ route('repositories.preview', ['repository' => $repository->id, 'page' => $contentFile->getURI()]) }}"
                    class="font-bold text-vt-blue-800 hover:text-vt-blue-900"
                    target="contentPreview"
                >
                    Preview your changes
                </a>.
            @endif
        </x-alert-banner>
    @endif

    <x-form-panel
        class="mt-3"
        method="PUT"
        action="{{ route('repositories.content.update', [$repository->id, $archetype->getSlug(), $contentFile->getSlug()]) }}"
    >
        <div class="col-span-6 lg:col-span-4">
            <x-jet-label for="slug" value="Slug" />
            <x-jet-input
                class="mt-1 block w-full"
                type="text"
                id="slug"
                name="slug"
                :value="$contentFile->getSlug()"/>
            <x-jet-input-error for="slug" class="mt-2" />
        </div>

        @foreach ($contentFile->getFrontMatter() as $frontMatterName => $frontMatterValue)
            <div class="col-span-6 lg:col-span-4">
                <x-jet-label :for="$frontMatterName" :value="Str::title($frontMatterName)" />

                <x-repositories.content.front-matter-input :name="$frontMatterName" :value="$frontMatterValue"/>
                <x-jet-input-error :for="$frontMatterName" class="mt-2" />
            </div>
        @endforeach

        <x-repositories.content.body-editor name="body" :body="$contentFile->getBody()"/>

        <x-slot name="actions">
            <x-jet-secondary-button
                href="{{ route('repositories.content.index', [$repository->id, $archetype->getSlug()]) }}"
            >
                Cancel
            </x-jet-secondary-button>
            <x-jet-button>
                Save
            </x-jet-button>
        </x-slot>
    </x-form-panel>
</x-repo-layout>
