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
            (
                $isCurrent
                ? 'bg-vt-lightGray-200 text-vt-darkGray-800'
                : 'text-vt-darkGray-500 hover:bg-vt-lightGray-100 hover:text-vt-darkGray-800'
            ),
        ]),
    ]) }}
    >
    <x-icon
        name="{{ $icon }}"
        class="{{ $isCurrent ? 'text-vt-darkGray-400' : 'text-vt-darkGray-400 group-hover:text-vt-darkGray-700' }} mr-3 h-6 w-6"
    />
    {{ $slot }}
</a>
