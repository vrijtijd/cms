@props(['repository'])

<x-tr>
    <x-td>
        <a href="{{ route('repositories.show', $repository->id) }}" class="text-vt-blue-800 hover:text-vt-blue-900">
            {{ $repository->name }}
        </a>
    </x-td>
    <x-td>
        {{ $repository->url }}
    </x-td>
    <x-td>
        <a
            href="{{ route('teams.show', $repository->team->id) }}"
            class="text-vt-blue-800 hover:text-vt-blue-900"
        >
            {{ $repository->team->name }}
        </a>
    </x-td>
    <x-td class="flex justify-end gap-2">
        <livewire:pull-repository-button :repository="$repository"/>

        @if ($repository->website)
            <a href="{{ $repository->website }}" target="_blank" class="text-vt-blue-800 hover:text-vt-blue-900">
                <x-icon-external-link class="w-6 h-6"/>
            </a>
        @endif
        <livewire:delete-repository-button
            :repositoryId="$repository->id"
            :name="$repository->name"/>
    </x-td>
</x-tr>
