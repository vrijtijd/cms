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
        <a href="{{ route('teams.show', $repository->team->id) }}" class="text-vt-blue-800 hover:text-vt-blue-900">
            {{ $repository->team->name }}
        </a>
    </x-td>
    <x-td class="flex justify-end gap-2">
        <div x-data="" x-init="window.tippy($el)" data-tippy-content="Pull changes">
            <livewire:pull-repository-button :repository="$repository"/>
        </div>

        @if ($repository->website)
            <a
                href="{{ $repository->website }}"
                target="_blank"
                class="text-vt-blue-800 hover:text-vt-blue-900"
                x-data=""
                x-init="window.tippy($el)"
                data-tippy-content="Visit live site"
            >
                <x-icon-external-link class="w-6 h-6"/>
            </a>
        @endif
        <a href="{{ route('admin.repositories.edit', [$repository->id]) }}"
            class="text-vt-blue-800 hover:text-vt-blue-900"
            x-data=""
            x-init="window.tippy($el)"
            data-tippy-content="Edit"
        >
            <x-icon-pencil class="w-6 h-6"/>
        </a>

        <div x-data="" x-init="window.tippy($el)" data-tippy-content="Delete">
            <livewire:delete-repository-button :repository="$repository" :name="$repository->name"/>
        </div>
    </x-td>
</x-tr>
