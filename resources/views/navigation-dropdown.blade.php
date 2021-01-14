<nav x-data="{ open: false }" class="bg-white border-b border-vt-lightGray-300">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-icon-logo class="w-10 h-10"/>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (Auth::user()->is_admin)
                        <x-jet-nav-link href="{{ route('admin') }}" :active="request()->routeIs('admin*')">
                            {{ __('Admin') }}
                        </x-jet-nav-link>
                    @endif

                    @foreach (Auth::user()->currentTeam->repositories as $repository)
                        <x-jet-nav-link
                            href="{{ route('repositories.show', $repository->id) }}"
                            :active="request()->fullUrlIs('*/repositories/'.$repository->id.'*')"
                        >
                            {{ $repository->name }}
                        </x-jet-nav-link>
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-vt-darkGray-400 hover:text-vt-darkGray-600 hover:border-vt-darkGray-200 focus:outline-none focus:text-vt-darkGray-600 focus:border-darkgray-200 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <x-icon-chevron-down class="h-4 w-4"/>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-vt-darkGray-200">
                            {{ __('Manage Account') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-jet-dropdown-link>

                        <div class="border-t border-vt-lightGray-300"></div>

                        <div class="block px-4 py-2 text-xs text-vt-darkGray-200">
                            {{ __('Manage Team') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                            {{ __('Team Settings') }}
                        </x-jet-dropdown-link>

                        <div class="border-t border-vt-lightGray-300"></div>

                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="block px-4 py-2 text-xs text-vt-darkGray-300">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" />
                            @endforeach

                            <div class="border-t border-vt-lightGray-300"></div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-dropdown-link href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-vt-darkGray-300 hover:text-vt-darkGray-400 hover:bg-vt-lightGray-300 focus:outline-none focus:bg-vt-lightGray-300 focus:text-vt-darkGray-400 transition duration-150 ease-in-out">
                    <x-icon-menu class="h-6 w-6"/>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-vt-lightGray-300">
            <div class="flex items-center px-4">
                <div>
                    <div class="font-medium text-base text-vt-darkGray-700">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-vt-darkGray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-jet-responsive-nav-link>
                </form>

                <div class="border-t border-vt-lightGray-300"></div>

                <div class="block px-4 py-2 text-xs text-vt-darkGray-200">
                    {{ __('Manage Websites') }}
                </div>

                @foreach (Auth::user()->currentTeam->repositories as $repository)
                    <x-jet-responsive-nav-link
                        href="{{ route('repositories.show', $repository->id) }}"
                        :active="request()->fullUrlIs('*/repositories/'.$repository->id.'*')"
                    >
                        {{ $repository->name }}
                    </x-jet-responsive-nav-link>
                @endforeach

                <div class="border-t border-vt-lightGray-300"></div>

                <div class="block px-4 py-2 text-xs text-vt-darkGray-200">
                    {{ __('Manage Team') }}
                </div>

                <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                    {{ __('Team Settings') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                    {{ __('Create New Team') }}
                </x-jet-responsive-nav-link>

                <div class="border-t border-vt-lightGray-300"></div>

                <div class="block px-4 py-2 text-xs text-vt-darkGray-200">
                    {{ __('Switch Teams') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                    <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                @endforeach
            </div>
        </div>
    </div>
</nav>
