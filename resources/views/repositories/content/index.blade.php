<x-repo-layout :repository="$repository">
    <h1 class="text-3xl font-bold">
        {{ $archetype }}
    </h1>

    <x-form-panel
        class="mt-4"
        method="POST"
        action="{{ route('repositories.content.store', [$repository->id, Str::slug($archetype)]) }}"
    >
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

    <x-table class="mt-3">
        <x-slot name="headings">
            <x-th>Title</x-th>
            <x-th><span class="sr-only">Edit</span></x-th>
        </x-slot>

        @foreach($contentFiles as $contentFile)
            <x-tr>
                <x-td>{{ $contentFile->getName() }}</x-td>
                <x-td class="flex justify-end gap-2">
                    <a
                        href="{{ route('repositories.content.edit', [$repository->id, Str::slug($archetype), $contentFile->getSlug()]) }}"
                        class="text-vt-blue-800 hover:text-vt-blue-900"
                    >
                        <x-icon-pencil class="w-6 h-6"/>
                    </a>
                    <livewire:delete-repository-content-button
                        :repositoryId="$repository->id"
                        :archetype="$archetype"
                        :slug="$contentFile->getSlug()"
                        :title="$contentFile->getName()" />
                </x-td>
            </x-tr>
        @endforeach
    </x-table>
</x-repo-layout>
