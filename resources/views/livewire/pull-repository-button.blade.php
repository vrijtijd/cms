<button
    class="text-vt-blue-800 hover:text-vt-blue-900"
    wire:click="pullRepository"
    wire:loading.attr="disabled"
>
    <span wire:loading>
        <x-icon-loading-indicator class="h-6 w-6"/>
    </span>
    <span wire:loading.remove>
        @if (session()->has('success'))
            <x-icon-check-circle/>
        @else
            <x-icon-cloud-download class="w-6 h-6"/>
        @endif
    </span>
</button>
