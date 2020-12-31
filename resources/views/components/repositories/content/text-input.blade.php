@props(['label', 'name', 'value'])

<div class="sm:col-span-4">
    <x-label for="{{ $label }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </x-label>
    <div class="mt-1 flex rounded-md shadow-sm">
        <x-input
            class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md sm:text-sm border-gray-300 border"
            type="text"
            :name="$name"
            :id="$label"
            :value="$value"/>
    </div>
</div>
