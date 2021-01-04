<div
    class="flex lg:static"
    x-data="{ open: false }"
    :class="{ 'bg-vt-darkGray-800 bg-opacity-80 absolute inset-x-0 inset-y-0': open }"
    >
    <div
        class="w-64 inset-y-0 z-10 hidden lg:flex"
        :class="{ 'hidden': !open, 'flex': open }"
        @click.away="open = false"
    >
        <div class="flex flex-grow border-r border-vt-lightGray-400 pt-2 pb-4 bg-white overflow-y-auto shadow-lg">
            <div class="flex-grow flex flex-col">
                <nav class="flex-1 px-2 bg-white space-y-1" aria-label="Sidebar">
                    {{ $slot }}
                </nav>
            </div>
        </div>
    </div>
    <div class="lg:hidden">
        <button @click="open = !open" class="p-3" :class="{ 'text-white': open, 'text-vt-darkGray-800': !open}">
            <span x-show="open">
                <x-icon-x class="w-8 h-8 text-vt-dark-gray-800"/>
            </span>
            <span x-show="!open">
                Open sidebar
            </span>
        </button>
    </div>
</div>

