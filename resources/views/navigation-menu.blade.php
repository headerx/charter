<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full px-4 mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block w-auto h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-5 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @foreach (\App\Models\Link::where('view', \App\Models\LinkMenu::NavigationMenu->value )->get() as
                    $link)
                    @if(Gate::allows('view', $link))

                    <x-nav-link href="{{ $link->url }}" target="{{ $link->target->value }}" title="{{ $link->title }}">
                        @isset($link->icon) @svg($link->icon, 'w-4 h-4') @endisset <span class="ml-1">{{ $link->label
                            }}</span>
                    </x-nav-link>
                    @endif

                    @endforeach

                    <x-nav-link href="#"
                        onclick="window.livewire.emit('creatingNewLink', '{{ \App\Models\LinkMenu::NavigationMenu->value }}')">
                        <button
                            class="flex items-center w-full px-2 py-3 text-gray-600 cursor-pointer justify-left hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                            @svg('heroicon-o-plus-circle', 'w-4 h-4') <span>{{ __('Add Bookmark') }}</span></button>
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Orgnizations Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="relative ml-3">
                    <x-jet-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                    <x-application-logo class="object-cover w-8 h-8 p-2 rounded-full" />

                                    {{ Auth::user()->currentTeam->name }}

                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <!-- Organization Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Organization') }}
                                </div>

                                <!-- Organization Settings -->
                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->uuid) }}">
                                    {{ __('Organization Settings') }}
                                </x-jet-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Organization') }}
                                </x-jet-dropdown-link>
                                @endcan

                                <div class="border-t border-gray-100"></div>

                                <!-- Organization Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Orgnizations') }}
                                </div>

                                @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" />
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button
                                class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                <img class="object-cover w-8 h-8 rounded-full"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                    {{ Auth::user()->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-2 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                            <div class="border-t border-gray-100"></div>


                            <x-collapsible-div-vertical>


                                <x-slot name="trigger">
                                    <div class="inline-flex flex-row px-2 py-1 text-xs text-gray-400">
                                        <span>
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path x-cloak x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    style="display: none;"></path>
                                                <path x-cloak x-show="open" d="M19 9L12 16L5 9" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg>
                                        </span>
                                        <span>
                                            {{ __('Bookmarks') }}
                                        </span>
                                    </div>
                                </x-slot>

                                <x-slot name="content">
                                    <x-jet-dropdown-link href="#" onclick="window.livewire.emit('creatingNewLink')">
                                        <button
                                            class="flex items-center w-full px-1 text-gray-600 cursor-pointer justify-left hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                                            @svg('heroicon-o-plus-circle', 'w-4 h-4') <span>{{ __('Add Bookmark')
                                                }}</span></button>
                                    </x-jet-dropdown-link>

                                    @foreach (\App\Models\Link::all() as $link)
                                    @if(Gate::allows('view', $link))

                                    <div
                                        class="grid items-center justify-end w-full grid-cols-2 gap-8 pr-2 text-gray-600">

                                        <x-jet-dropdown-link class="grid items-center grid-cols-2"
                                            href="{{ $link->url }}" target="{{ $link->target->value }}"
                                            title="{{ $link->title }}">
                                            @isset($link->icon) @svg($link->icon, 'w-4 h-4') @endisset <span
                                                class="ml-1">{{
                                                $link->label }}</span>
                                        </x-jet-dropdown-link>

                                        @if(Gate::allows('update', $link))
                                        <div class="flex flex-row items-center justify-end">
                                            <x-jet-dropdown-link href="#"
                                                onclick="window.livewire.emit('editingLink', '{{ $link->uuid }}')">
                                                @svg('heroicon-o-pencil', 'w-4 h-4')
                                            </x-jet-dropdown-link>


                                            <x-jet-dropdown-link href="#"
                                                onclick="window.livewire.emit('showDeleteLinkModal', '{{ $link->uuid }}')">
                                                @svg('heroicon-o-trash', 'w-4 h-4')
                                            </x-jet-dropdown-link>
                                        </div>
                                        @endif

                                    </div>
                                    @endif

                                    @endforeach
                                </x-slot>
                                </x-collapsible-folder-solid>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="mr-3 shrink-0">
                    <img class="object-cover w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
                    :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}"
                    :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Organization Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Organization') }}
                </div>

                <!-- Organization Settings -->
                <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->uuid) }}"
                    :active="request()->routeIs('teams.show')">
                    {{ __('Organization Settings') }}
                </x-jet-responsive-nav-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <x-jet-responsive-nav-link href="{{ route('teams.create') }}"
                    :active="request()->routeIs('teams.create')">
                    {{ __('Create New Organization') }}
                </x-jet-responsive-nav-link>
                @endcan

                <div class="border-t border-gray-200"></div>

                <!-- Organization Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Switch Orgnizations') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                <x-switchable-team :team="$team" component="jet-responsive-nav-link" />
                @endforeach
                @endif

                <div class="border-t border-gray-200"></div>

                <x-collapsible-folder-solid>

                    <div class="block py-2 text-xs text-gray-400">

                        <x-slot name="icon">
                            <span>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path x-cloak x-show="! openFolder" d="M9 5L16 12L9 19" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        style="display: none;"></path>
                                    <path x-cloak x-show="openFolder" d="M19 9L12 16L5 9" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </x-slot>
                        <x-slot name="header">
                            {{ __('Bookmarks') }}
                        </x-slot>
                    </div>

                    <x-jet-responsive-nav-link class="flex items-center" href="#"
                        onclick="window.livewire.emit('creatingNewLink')">
                        <button
                            class="flex items-center w-full px-2 py-3 text-gray-600 cursor-pointer justify-left hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                            @svg('heroicon-o-plus-circle', 'w-4 h-4') <span>{{ __('Add Bookmark') }}</span></button>
                    </x-jet-responsive-nav-link>

                    @foreach (\App\Models\Link::all() as $link)
                    @if(Gate::allows('view', $link))

                    <div class="grid grid-cols-2">

                        <x-jet-responsive-nav-link class="flex items-center" href="{{ $link->url }}"
                            target="{{ $link->target->value }}" title="{{ $link->title }}">
                            @isset($link->icon) @svg($link->icon, 'w-4 h-4') @endisset <span class="ml-1">{{
                                $link->label
                                }}</span>
                        </x-jet-responsive-nav-link>

                        @if(Gate::allows('update', $link))
                        <div class="flex flex-row items-center justify-end">
                            <x-jet-dropdown-link onclick="window.livewire.emit('editingLink', '{{ $link->uuid }}')">
                                @svg('heroicon-o-pencil', 'w-4 h-4')
                            </x-jet-dropdown-link>


                            <x-jet-dropdown-link
                                onclick="window.livewire.emit('showDeleteLinkModal', '{{ $link->uuid }}')">
                                @svg('heroicon-o-trash', 'w-4 h-4')
                            </x-jet-dropdown-link>
                        </div>
                        @endif
                    </div>
                    @endif

                    @endforeach


                </x-collapsible-folder-solid>
            </div>
        </div>
    </div>
</nav>
