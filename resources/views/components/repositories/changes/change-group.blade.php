<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-2xl">
            @switch($changeType)
                @case('A')
                    You Created
                @break

                @case('D')
                    You Deleted
                @break

                @case('M')
                    You Edited
                @break

                @case('R')
                    You Renamed
                @break
            @endswitch
        </h3>

        <ul class="flex flex-col gap-3 mt-4">
            @foreach ($changes as $change)
                <x-repositories.changes.change :change="$change" :archetypes="$archetypes" :repository="$repository"/>
            @endforeach
        </ul>
    </div>
</div>
