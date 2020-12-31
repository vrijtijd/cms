@props(['body', 'name'])

<div class="sm:col-span-6">
    <x-label for="body" class="block text-sm font-medium text-gray-700">
        Body
    </x-label>
    <div class="mt-1">
        <x-textarea
            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border"
            id="{{ $name }}"
            name="{{ $name }}">{{ $body }}</x-textarea>
    </div>
</div>
