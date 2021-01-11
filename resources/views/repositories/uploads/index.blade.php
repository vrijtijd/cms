<x-repo-layout :repository="$repository">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">
            Uploads
        </h1>

        <livewire:upload-file-button :repository="$repository"/>
    </div>

    <div class="mt-4">
        <livewire:uploaded-file-list :repository="$repository"/>
    </div>
</x-repo-layout>
