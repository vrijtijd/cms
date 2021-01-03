@props(['team', 'component' => 'jet-dropdown-link'])

<form method="POST" action="{{ route('current-team.update') }}">
    @method('PUT')
    @csrf

    <input type="hidden" name="team_id" value="{{ $team->id }}">

    <x-dynamic-component :component="$component" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
        <div class="flex items-center">
            @if (Auth::user()->isCurrentTeam($team))
                <x-icon-check-circle class="mr-2 h-5 w-5 text-vt-blue-500"/>
            @endif

            <div class="truncate">{{ $team->name }}</div>
        </div>
    </x-dynamic-component>
</form>
