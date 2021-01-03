@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-vt-pink-400 text-base font-medium text-vt-pink-800 bg-vt-pink-100 focus:outline-none focus:text-vt-pink-900 focus:bg-vt-pink-200 focus:border-vt-pink-800 transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-vt-darkGray-500 hover:text-vt-darkGray-700 hover:bg-vt-lightGray-100 hover:border-vt-darkGray-200 focus:outline-none focus:text-vt-darkGray-700 focus:bg-vt-lightGray-100 focus:border-vt-darkGray-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
