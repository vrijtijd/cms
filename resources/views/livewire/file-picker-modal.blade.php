<x-jet-dialog-modal wire:model="isModalOpen">
    <x-slot name="title">
        {{ __('Choose File') }}
    </x-slot>

    <x-slot name="content">
        <div class="text-right">
            <livewire:upload-file-button :repository="$repository"/>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4 mt-3">
            @foreach ($filenames as $filename)
                <button
                    class="rounded-md overflow-hidden h-32 border-2 hover:border-vt-blue-600 focus:border-vt-blue-600"
                    wire:click="$emit('filePicked', '{{ $filename }}')"
                >
                    <img
                        class="h-full w-full object-cover"
                        src="{{ route('repositories.uploads.show', [$repository->id, $filename]) }}"
                        alt=""/>
                </button>
            @endforeach
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('isModalOpen', false)" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>
    </x-slot>
</x-jet-dialog-modal>
