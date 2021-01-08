<x-repo-layout :repository="$repository">
    @if (session('published'))
        <x-alert-banner class="mb-5">
            Your changes have been published!
            @if ($repository->website)
                You should be able to
                <a href="{{ $repository->website }}" target="_blank" class="font-bold text-vt-blue-800 hover:text-vt-blue-900">see your changes live</a>
                in the next couple of minutes.
            @endif
        </x-alert-banner>
    @endif

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
                <x-form-panel
                    method="PUT"
                    action="{{ route('repositories.publish', [$repository->id]) }}"
                >
                    <div class="col-span-6">
                        <x-jet-label for="commit-message" value="Describe your changes" />

                        <x-textarea id="commit-message" rows="5" class="form-input rounded-md shadow-sm w-full resize-none" name="commitMessage">
                            {{ Auth::user()->name . ' publishing changes from ' . config('app.url') }}
                        </x-textarea>
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
            </div>
        </div>
    @endif
</x-repo-layout>
