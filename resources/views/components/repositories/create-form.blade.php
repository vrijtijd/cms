<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        Add new
    </h3>
</div>

<x-form
    method="POST"
    action="{{ route('admin.repositories.store') }}"
    class="space-y-4 divide-y divide-gray-300"
    >
    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
        <x-label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            Name
        </x-x-label>
        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <x-input type="text" name="name" id="name" autocomplete="given-name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md border"/>
        </div>
    </div>

    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
        <x-label for="url" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            URL
        </x-label>
        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <x-input type="text" name="url" id="url" autocomplete="given-name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md border"/>
        </div>
    </div>

    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
        <x-label for="website" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            Website
        </x-label>
        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <x-input type="text" name="website" id="website" autocomplete="given-name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md border"/>
        </div>
    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save
            </button>
        </div>
    </div>
</x-form>
