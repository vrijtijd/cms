@props(['team'])

<x-tr>
    <x-td>
        {{ $team->name }}
    </x-td>
    <x-td>
        {{ $team->owner->name }}
    </x-td>
    <x-td>
        @foreach ($team->allUsers() as $member)
            {{ $member->name }} ({{ $member->teamRole($team)->name }})
            @if (!$loop->last)
                ,
            @endif
        @endforeach
    </x-td>
    <x-td class="flex justify-end gap-2">
        <a
            href="{{ route('teams.show', $team->id) }}"
            class="text-vt-blue-800 hover:text-vt-blue-900"
            x-data=""
            x-init="window.tippy($el)"
            data-tippy-content="Edit"
        >
            <x-icon-pencil class="w-6 h-6" />
        </a>
    </x-td>
</x-tr>

