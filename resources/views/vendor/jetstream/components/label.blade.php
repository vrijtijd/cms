@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-vt-darkGray-600']) }}>
    {{ $value ?? $slot }}
</label>
