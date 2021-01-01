<a
    {{ $attributes->merge([
        'href' => $href,
        'class' => implode(' ', [
            'group',
            'flex',
            'items-center',
            'px-2',
            'py-2',
            'text-sm',
            'font-medium',
            'rounded-md',
            ($isCurrent ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'),
        ]),
    ]) }}
    >
    <x-icon
        name="{{ $icon }}"
        class="{{ $isCurrent ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 h-6 w-6"
    />
    {{ $slot }}
</a>
