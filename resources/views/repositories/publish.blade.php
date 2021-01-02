<x-repo-layout :repository="$repository">
    <h1 class="text-3xl font-bold">
        Publish
    </h1>

    <div class="max-w-prose">
        @if (!$hasChanges)
            <p class="mt-3">
                There's nothing to publish! Add/edit/delete content in order to publish changes to your website.
            </p>
        @else
            <p class="mt-3">
                There are changes to your website! In order for the website to get updated, you need to publish the changes. Please make sure to <a class="text-indigo-600 hover:text-indigo-800" href="{{ route('repositories.preview', $repository->id) }}" target="_blank">preview</a> your website first to make sure it looks how you want it to.
            </p>

            <livewire:publish-repository-form :repository="$repository"/>
        @endif
    </div>
</x-repo-layout>
