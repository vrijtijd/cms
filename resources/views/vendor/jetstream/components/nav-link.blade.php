@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-vt-pink-500 text-sm font-medium leading-5 text-vt-darkGray-600 focus:outline-none focus:border-vt-pink-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-vt-darkGray-400 hover:text-vt-darkGray-600 hover:border-vt-darkGray-300 focus:outline-none focus:text-vt-darkGray-600 focus:border-vt-darkGray-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
