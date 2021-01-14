@php($isOrdered = $archetype->isOrdered())

@push('scripts')
    @if ($isOrdered)
        <script src="{{ mix('js/content-table.js') }}"></script>
    @endif
@endpush

<x-repo-layout :repository="$repository">
    <h1 class="text-3xl font-bold">
        {{ $archetype->getName() }}
    </h1>

    <x-form-panel
        class="mt-4"
        method="POST"
        action="{{ route('repositories.content.store', [$repository->id, $archetype->getSlug()]) }}"
    >
        <x-input
            type="hidden"
            name="timezoneOffsetInMinutes"
            x-data="{ offset: -(new Date()).getTimezoneOffset() }"
            x-model="offset"
            />

        <div class="col-span-6 lg:col-span-4">
            <x-jet-label for="title" value="Title" />

            <x-jet-input
                class="mt-1 block w-full"
                type="text"
                name="title"
                id="title"/>

            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <x-slot name="actions">
            <x-jet-button>
                Create
            </x-jet-button>
        </x-slot>
    </x-form-panel>

    <x-table class="mt-3" id="content-table">
        <x-slot name="headings">
            @if ($isOrdered)
                <x-th>
                    <livewire:save-content-file-order-button :repository="$repository" :archetypeSlug="$archetype->getSlug()" />
                </x-th>
            @endif
            <x-th class="text-left">Title</x-th>
            <x-th><span class="sr-only">Edit</span></x-th>
        </x-slot>

        @foreach($contentFiles as $contentFile)
            <x-tr
                class="bg-white"
                data-content-file-slug="{{ $contentFile->getSlug() }}"
                x-data="{ dragging: false }"
                x-bind:class="{ 'cursor-grabbing': dragging }"
                @mouseup="dragging = false"
            >
                @if ($isOrdered)
                    <x-td
                        data-is-drag-handle
                        x-bind:class="{ 'cursor-grabbing': dragging, 'cursor-grab': !dragging }"
                        @mousedown="dragging = true"
                        @mouseup="dragging = false"
                    >
                        <x-icon-menu class="h-6 w-6"/>
                    </x-td>
                @endif
                <x-td class="w-full">{{ $contentFile->getName() }}</x-td>
                <x-td class="flex justify-end gap-2">
                    @if ($canPreview)
                        <a
                            href="{{ route('repositories.preview', ['repository' => $repository->id, 'page' => $contentFile->getURI()]) }}"
                            class="font-bold text-vt-blue-800 hover:text-vt-blue-900"
                            target="contentPreview"
                        >
                            <x-icon-eye class="w-6 h-6"/>
                        </a>

                        @if ($repository->website)
                            <a
                                href="{{ "{$repository->website}{$contentFile->getURI()}" }}"
                                class="font-bold text-vt-blue-800 hover:text-vt-blue-900"
                                target="_blank"
                            >
                                <x-icon-external-link class="w-6 h-6"/>
                            </a>
                        @endif
                    @endif
                    <a
                        href="{{ route('repositories.content.edit', [$repository->id, $archetype->getSlug(), $contentFile->getSlug()]) }}"
                        class="text-vt-blue-800 hover:text-vt-blue-900"
                    >
                        <x-icon-pencil class="w-6 h-6"/>
                    </a>
                    <livewire:delete-repository-content-button
                        :repository="$repository"
                        :archetypeSlug="$archetype->getSlug()"
                        :contentFileSlug="$contentFile->getSlug()"
                        :title="$contentFile->getName()" />
                </x-td>
            </x-tr>
        @endforeach
    </x-table>
</x-repo-layout>
