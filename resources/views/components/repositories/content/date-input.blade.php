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

<x-input
    type="hidden"
    :name="$name"
    x-bind:value="date + 'T' + time + ':00' + window.timezone"/>

<div class="flex gap-2">
    <x-jet-input
        class="flex-1"
        type="date"
        required
        :id="$label"
        :name='$dateName'
        :value="$dateValue"
        x-model="date"/>

    <x-jet-input
        class="flex-1"
        type="time"
        required
        :name='$timeName'
        :value="$timeValue"
        x-model="time"/>
</div>
