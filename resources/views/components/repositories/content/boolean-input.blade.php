@props(['label', 'name', 'value'])

<div class="sm:col-span-4" x-data="{ value: {{ $value ? 'true' : 'false' }} }">
    <x-label :for="$label" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </x-label>
    <div class="mt-1 rounded-md">
        <x-input type="hidden" :name="$name" :value="$value" x-model="value" />

            <div>
                <button
                    type="button"
                    aria-pressed="false"
                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :class="{ 'bg-gray-200': !value, 'bg-indigo-600': value }"
                    @click="value = !value"
                >
                  <span class="sr-only">{{ $label }}</span>
                  <span
                      aria-hidden="true"
                      class="inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"
                        :class="{ 'translate-x-0': !value, 'translate-x-5': value }"
                  ></span>
                </button>
            </div>
    </div>
</div>

