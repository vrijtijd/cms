@props(['user'])

<x-tr>
    <x-td>
        {{ $user->name }}
    </x-td>
    <x-td>
        @foreach ($user->allTeams() as $team)
            <a href="{{ route('teams.show', $team->id) }}" class="text-vt-blue-800 hover:text-vt-blue-900">
                {{ $team->name }}
            </a>
            @if (!$loop->last)
                ,
            @endif
        @endforeach
    </x-td>
    <x-td class="flex justify-end gap-2">
        <a href="mailto:{{ $user->email }}" class="text-vt-blue-800 hover:text-vt-blue-900">
            <x-icon-mail class="w-6 h-6" />
        </a>
    </x-td>
</x-tr>

