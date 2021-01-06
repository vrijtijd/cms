<x-repo-layout :repository="$repository">
    @if (!$hasChanges)
        <p class="text-sm text-vt-darkGray-500">
            There's nothing to publish! Add/edit/delete content in order to publish changes to your website.
        </p>
    @else
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <x-jet-section-title>
                <x-slot name="title">Publish</x-slot>
                <x-slot name="description">
                    There are changes to your website! In order for the website to get updated, you need to publish the changes. Please make sure to <a class="text-vt-blue-800 hover:text-vt-blue-900" href="{{ route('repositories.preview', $repository->id) }}" target="_blank">preview</a> your website first to make sure it looks how you want it to.

                </x-slot>
            </x-jet-section-title>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <livewire:publish-repository-form :repository="$repository"/>
            </div>
        </div>
    @endif
</x-repo-layout>
