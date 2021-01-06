<div class="flex bg-white p-4 items-center justify-end md:justify-between border-b border-vt-darkGray-100" wire:key="preview-status-bar">
    <h1 class="hidden md:block">Previewing {{ $repository->name }}</h1>
    <x-jet-button wire:click="$emit('buildStarted')" id="refresh-preview-button">
        Refresh preview
    </x-jet-button>
</div>
