@once
    @push('scripts')
        <script>
            (function() {
                var timezoneOffset = -(new Date().getTimezoneOffset())
                var sign = timezoneOffset < 0 ? '-' : '+'
                var hours = Math.abs(Math.floor(timezoneOffset / 60))
                var minutes = Math.abs(Math.floor(timezoneOffset % 60))

                window.timezone = [
                    sign,
                    hours.toString().padStart(2, 0),
                    ':',
                    minutes.toString().padStart(2, 0),
                ].join('')
            })();
        </script>
    @endpush
@endonce

<div class="sm:col-span-4" x-data="{ date: '{{ $dateValue }}', time: '{{ $timeValue }}' }">
    <x-label :for="$label" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </x-label>
    <div class="mt-1 flex rounded-md shadow-sm">
        <x-input type="hidden" :name="$name" x-bind:value="date + 'T' + time + ':00' + window.timezone" />
        <x-input
            class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md sm:text-sm border-gray-300 border"
            id="{{ $label }}"
            type="date"
            required
            :name='$dateName'
            :value="$dateValue"
            x-model="date"/>
        <x-input
            class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 rounded-md sm:text-sm border-gray-300 border ml-4"
            type="time"
            name=''
            required
            :name='$timeName'
            :value="$timeValue"
            x-model="time" />
    </div>
</div>
