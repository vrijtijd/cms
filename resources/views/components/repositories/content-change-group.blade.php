@props(['type', 'changes', 'repository'])

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-2xl">
            @switch($type)
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
                <li class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-vt-blue-100 text-vt-blue-800">
                        {{ Str::singular($change->getArchetype()->getName()) }}
                    </span>

                    @if ($type === 'D')
                        {{ $change->getOldName() }}
                    @elseif ($type === 'R')
                        <div>
                            <span class="font-bold">{{ $change->getOldName() }}</span>
                            to
                            <a
                                class="text-vt-blue-800 hover:text-vt-blue-900"
                                href="{{ route('repositories.content.edit', [
                                    $repository->id,
                                    $change->getArchetype()->getSlug(),
                                    $change->getContentFile()->getSlug(),
                                ])}}"
                            >
                                <span class="font-bold">{{ $change->getContentFile()->getName() }}</span>
                            </a>
                        </div>
                    @else
                        <a
                            class="text-vt-blue-800 hover:text-vt-blue-900"
                            href="{{ route('repositories.content.edit', [
                                $repository->id,
                                $change->getArchetype()->getSlug(),
                                $change->getContentFile()->getSlug(),
                            ])}}"
                        >
                            {{ $change->getContentFile()->getName() }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
