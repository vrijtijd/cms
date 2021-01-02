<div
    class="space-y-4 divide-y divide-gray-200"
    x-data="{ publishing: false }"
>
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Describe your changes
                    </label>
                    <div class="mt-1">
                        <textarea
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border"
                            id="description"
                            wire:model.lazy="commitMessage"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5">
        <div class="flex justify-end">
            <button
                type="reset"
                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                Cancel
            </button>
            <button
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                wire:click="publish"
                @click="publishing = true"
                :class="{ 'hover:bg-indigo-700': !publishing }"
                x-bind:disabled="publishing"
            >
                <span :class="{ hidden: !publishing }">Publishing…</span>
                <span :class="{ hidden: publishing }">Publish</span>
            </button>
        </div>
    </div>
</div>
