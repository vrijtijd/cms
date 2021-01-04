<button {{ $attributes->merge([
    'type' => 'button',
    'class' => 'inline-flex items-center px-4 py-2 bg-white border border-vt-darkGray-100 rounded-md font-semibold text-xs text-vt-darkGray-600 uppercase tracking-widest shadow-sm hover:text-vt-darkGray-400 focus:outline-none focus:border-vt-blue-500 focus:shadow-outline-blue active:text-vt-darkGray-700 active:bg-vt-lightGray-100 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
