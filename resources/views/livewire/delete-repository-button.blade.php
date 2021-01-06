<div>
    <button class="text-red-600 hover:text-red-800 font-bold" wire:click="$toggle('isModalOpen')">
        <x-icon-trash class="w-6 h-6"/>
    </button>

    <x-jet-confirmation-modal wire:model="isModalOpen">
        <x-slot name="title">
            Delete <span class="font-bold">{{ $name }}</span>
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete <span class="font-bold">{{ $name }}</span>?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('isModalOpen')" wire:loading.attr="disabled">
                No
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteRepository" wire:loading.attr="disabled">
                Yes
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
