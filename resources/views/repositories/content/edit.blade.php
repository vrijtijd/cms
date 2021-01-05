@push('styles')
    <link rel="stylesheet" href="{{ mix('css/simplemde.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/content-editor.js') }}"></script>
@endpush

<x-repo-layout :repository="$repository">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ $contentFile->getName() }}
        </h3>
    </div>

    <x-form
        class="space-y-4 divide-y divide-gray-200"
        method="PUT"
        action="{{ route('repositories.content.update', [$repository->id, $archetype, $contentFile->getSlug()]) }}"
        x-data=""
    >
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <x-jet-input
                        class="mt-1 block w-full"
                        type="text"
                        id="slug"
                        name="slug"
                        :value="$contentFile->getSlug()"/>

                    @foreach ($contentFile->getFrontMatter() as $frontMatterName => $frontMatterValue)
                        <x-repositories.content.front-matter-input :name="$frontMatterName" :value="$frontMatterValue"/>
                    @endforeach

                    <x-repositories.content.body-editor name="body" :body="$contentFile->getBody()"/>
                </div>
            </div>
        </div>
        <div class="pt-5">
            <div class="flex justify-end">
                <button
                    type="reset"
                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    @click="window.editor.value(document.getElementById('body').value)"
                >
                    Cancel
                </button>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>
        </div>
    </x-form>
</x-repo-layout>
