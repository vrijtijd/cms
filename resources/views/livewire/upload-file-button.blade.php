<form wire:submit.prevent="upload" x-data="" x-ref="form">
    <input
        type="file"
        class="hidden"
        accept=".gif,.jpg,.jpeg,.png,.webm"
        x-ref="fileInput"
        @change="@this.upload('file', $refs.fileInput.files[0], () => { $refs.submitButton.click() })"
    >
    <button type="submit" class="hidden" x-ref="submitButton"></button>

    <x-jet-button
        type="button"
        @click="$refs.fileInput.click()"
    >
        <div class="flex gap-2" wire:loading.remove>
            <x-icon-upload class="h-4 w-4"/>
            Upload
        </div>
        <x-icon-loading-indicator class="h-4 w-4" wire:loading/>
    </x-jet-button>
</form>
