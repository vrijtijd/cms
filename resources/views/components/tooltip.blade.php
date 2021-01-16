<div {{ $attributes->merge([
    'class' => 'relative z-50',
    'x-data' => '{ show: false }',
    '@mouseenter' => 'show = true',
    '@mouseleave' => 'show = false',
]) }}>
    <div
        class="absolute left-1/2 transform -translate-x-1/2 -translate-y-3/4 hidden"
        :class="{ hidden: !show }"
    >
        <div class="bg-vt-darkGray-900 text-white rounded p-2">
            {{ $tooltip }}
        </div>
        <x-icon-chevron-down
            class="h-6 w-6 mx-auto text-vt-darkGray-900 relative transform -translate-y-1/2"
            fill="currentColor"/>
    </div>

    {{ $slot }}
</div>
