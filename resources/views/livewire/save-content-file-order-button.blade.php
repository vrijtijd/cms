<div x-data="{ loading: false }" x-init="Livewire.on('changesSaved', function() { loading = false })">
    @if ($hasChanges)
        <button
            class="text-vt-blue-600 hover:text-white hover:bg-vt-blue-600 rounded-full relative"
            :class="{ block: !loading, hidden: loading}"
            @click="Livewire.emit('saveOrder', window.getOrderedContentFiles()); loading = true"
        >
            <span class="animate-ping absolute inline-flex inset-0 rounded-full bg-vt-blue-400 opacity-75"></span>
            <x-icon-check-circle class="h-6 w-6" />
        </button>
        <x-icon-loading-indicator class="h-6 w-6 hidden" x-bind:class="{ block: loading, hidden: !loading}" />
    @else
        <x-icon-switch-vertical class="h-6 w-6"/>
    @endif
</div>
