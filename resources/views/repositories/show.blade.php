<x-repo-layout :repository="$repository">
    <div class="text-3xl font-bold">
        {{ $repository->name }}
    </div>
    <p class="mt-4 max-w-prose">
        In order to get started, select a content type in the sidebar. Once you've finished making changes, don't forget to publish them so that your website updates!
    </p>
</x-repo-layout>
