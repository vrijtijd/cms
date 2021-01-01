<div class="flex bg-white p-4 items-center justify-between border-b border-gray-300" wire:key="preview-status-bar">
    <h1>Previewing {{ $repository->name }}</h1>
    <button
        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        wire:click="refreshPreview"
        wire:loading.class.remove="hover:bg-indigo-700"
        wire:loading.attr="disabled"
    >
        <span wire:loading>Loading…</span>
        <span wire:loading.remove>Refresh preview</span>
    </button>
</div>
