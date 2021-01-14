<div x-data="{ loading: false }" x-init="Livewire.on('changesSaved', function() { loading = false })">
    @if ($hasChanges)
        <button
            class="text-vt-blue-600 hover:text-white hover:bg-vt-blue-600 rounded-full"
            :class="{ block: !loading, hidden: loading}"
            @click="Livewire.emit('saveOrder', window.getOrderedContentFiles()); loading = true"
        >
            <x-icon-check-circle class="h-6 w-6" />
        </button>
        <x-icon-loading-indicator class="h-6 w-6 hidden" x-bind:class="{ block: loading, hidden: !loading}" />
    @else
        <x-icon-switch-vertical class="h-6 w-6"/>
    @endif
</div>
