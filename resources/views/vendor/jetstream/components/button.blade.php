<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-vt-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-vt-blue-900 focus:outline-none focus:border-vt-blue-900 focus:shadow-outline-gray disabled:opacity-90 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
