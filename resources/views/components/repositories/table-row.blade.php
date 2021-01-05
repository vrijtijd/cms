@props(['repository'])

<tr class="whitespace-nowrap text-sm text-vt-darkGray-800">
    <td class="px-6 py-4">
        <a href="{{ route('repositories.show', $repository->id) }}" class="text-vt-blue-800 hover:text-vt-blue-900">
            {{ $repository->name }}
        </a>
    </td>
    <td class="px-6 py-4">
        {{ $repository->url }}
    </td>
    <td class="px-6 py-4">
        <a
            href="{{ route('teams.show', $repository->team->id) }}"
            class="text-vt-blue-800 hover:text-vt-blue-900"
        >
            {{ $repository->team->name }}
        </a>
    </td>
    <td class="px-6 py-4 flex justify-end gap-2">
        <livewire:pull-repository-button :repository="$repository"/>

        @if ($repository->website)
            <a href="{{ $repository->website }}" target="_blank" class="text-vt-blue-800 hover:text-vt-blue-900">
                <x-icon-external-link class="w-6 h-6"/>
            </a>
        @endif
        <x-form-button
            :action="route('admin.repositories.destroy', $repository->id)"
            method="DELETE"
            class="text-red-600 hover:text-red-800 font-bold"
            x-data=""
            @click="return confirm('Are you sure?')"
        >
            <x-icon-trash class="w-6 h-6"/>
        </x-form-button>
    </td>
</tr>
