@props(['method', 'action'])

<x-form :method="$method" :action="$action" {{ $attributes }}>
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                {{ $slot }}
            </div>
        </div>

        @if (isset($actions))
            <div class="flex items-center justify-end px-4 py-3 bg-vt-lightGray-100 text-right sm:px-6 gap-2">
                {{ $actions }}
            </div>
        @endif
    </div>
</x-form>
