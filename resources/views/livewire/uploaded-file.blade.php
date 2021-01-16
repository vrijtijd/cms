<div>
    <div class="rounded-md overflow-hidden h-48 flex border border-vt-lightGray-500">
        <div class="flex-1">
            <img class="h-full w-full object-cover" src="{{ route('repositories.uploads.show', [$repository->id, $filename, 'timestamp' => $timestamp]) }}" alt="" />
        </div>
        <div class="bg-white border-l border-vt-lightGray-500 flex flex-col divide-y divide-vt-gray-500">
            <a
                href="{{ route('repositories.uploads.show', [$repository->id, $filename]) }}"
                class="text-vt-blue-600 hover:bg-vt-lightGray-100 focus:bg-vt-lightGray-100 w-full p-2 flex-1 flex items-center"
                target="_blank"
                x-data=""
                x-init="window.tippy($el)"
                data-tippy-content="Open in a new tab"
            >
                <x-icon-external-link class="w-6 h-6 mx-auto"/>
            </a>
            <form
                wire:submit.prevent="replace"
                x-data="{ loading: false }"
                x-ref="form"
                x-init="window.tippy($el)"
                data-tippy-content="Replace file"
                class="flex flex-1"
            >
                <input
                    type="file"
                    class="hidden"
                    accept=".gif,.jpg,.jpeg,.png,.webm"
                    x-ref="fileInput"
                    @change="loading = true; @this.upload('replacementFile', $refs.fileInput.files[0], () => { loading = false; $refs.submitButton.click() })"
                >
                <button type="submit" class="hidden" x-ref="submitButton"></button>

                <button
                    class="text-vt-pink-600 hover:bg-vt-lightGray-100 focus:bg-vt-lightGray-100 w-full p-2"
                    type="button"
                    @click="$refs.fileInput.click()"
                >
                    <x-icon-switch-horizontal class="w-6 h-6 mx-auto" x-bind:class="{ hidden: loading }"/>
                    <x-icon-loading-indicator class="hidden h-6 w-6" x-bind:class="{ hidden: !loading }"/>
                </button>
            </form>
            <button
                class="text-red-500 hover:bg-vt-lightGray-100 focus:bg-vt-lightGray-100 w-full p-2 flex-1"
                wire:click="$toggle('isModalOpen')"
                wire:loading.attr="disabled"
                wire:loading.class.remove="hover:bg-vt-lightGray-100 focus:bg-vt-lightGray-100"
                x-data=""
                x-init="window.tippy($el)"
                data-tippy-content="Delete"
            >
                <x-icon-trash class="w-6 h-6 mx-auto"/>
            </button>
        </div>
    </div>
    <div class="text-sm text-center mt-2 overflow-ellipsis whitespace-nowrap overflow-hidden">
        {{ basename($filename) }}
    </div>

    <x-jet-confirmation-modal wire:model="isModalOpen">
        <x-slot name="title">
            {{ __('Delete File') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this file?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('isModalOpen')" wire:loading.attr="disabled">
                {{ __('No') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Yes') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>
