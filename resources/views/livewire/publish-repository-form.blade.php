<x-form-panel
    method="''"
    action="''"
    wire:submit="publish"
>
    <div class="col-span-6">
        <x-jet-label for="commit-message" value="Describe your changes" />

        <textarea id="commit-message" rows="5" class="form-input rounded-md shadow-sm w-full resize-none" wire:model.lazy="commitMessage"></textarea>
    </div>

    <x-slot name="actions">
        <x-jet-button
            x-data="{ publishing: false }"
            x-bind:disabled="publishing"
            x-bind:class="{ 'hover:bg-vt-900': !publishing }"
            @click="publishing = true"
        >
            <span :class="{ hidden: !publishing }">Publishing…</span>
            <span :class="{ hidden: publishing }">Publish</span>
        </x-jet-button>
    </x-slot>
</x-form-panel>
