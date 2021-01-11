<li class="flex items-center gap-2">
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-vt-blue-100 text-vt-blue-800">
        {{ $label }}
    </span>

    @if ($changeType === 'D')
        {{ $oldFileName }}
    @elseif ($changeType === 'R')
        <div>
            <span class="font-bold">{{ $oldFileName }}</span>
            to
            <a class="text-vt-blue-800 hover:text-vt-blue-900" href="{{ $link }}">
                <span class="font-bold">{{ $fileName }}</span>
            </a>
        </div>
    @else
        <a class="text-vt-blue-800 hover:text-vt-blue-900" href="{{ $link }}">
            {{ $fileName }}
        </a>
    @endif
</li>
