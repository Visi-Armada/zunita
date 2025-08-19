<nav x-data="{ open: false }" class="mckinsey-nav">
    <!-- Primary Navigation Menu -->
    <div class="mckinsey-container">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="mckinsey-nav-brand">
                        YB Dato' Zunita Begum
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="mckinsey-nav-link">
                        {{ __('Utama') }}
                    </x-nav-link>
                    <x-nav-link href="#about" class="mckinsey-nav-link">
                        {{ __('Tentang') }}
                    </x-nav-link>
                    <x-nav-link href="#statistics" class="mckinsey-nav-link">
                        {{ __('Statistik') }}
                    </x-nav-link>
                    <x-nav-link href="#initiatives" class="mckinsey-nav-link">
                        {{ __('Inisiatif') }}
                    </x-nav-link>
                    <x-nav-link href="#contact" class="mckinsey-nav-link">
                        {{ __('Hubungi') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-mckinsey-gray rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mckinsey-navy transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.edit') }}" class="text-mckinsey-gray hover:text-mckinsey-navy">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();"
                                         class="text-mckinsey-gray hover:text-mckinsey-navy">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-mckinsey-gray hover:text-mckinsey-navy hover:bg-mckinsey-light-blue focus:outline-none focus:bg-mckinsey-light-blue focus:text-mckinsey-navy transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="mckinsey-nav-link">
                {{ __('Utama') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#about" class="mckinsey-nav-link">
                {{ __('Tentang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#statistics" class="mckinsey-nav-link">
                {{ __('Statistik') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#initiatives" class="mckinsey-nav-link">
                {{ __('Inisiatif') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#contact" class="mckinsey-nav-link">
                {{ __('Hubungi') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-mckinsey-border">
            <div class="px-4">
                <div class="font-medium text-base text-mckinsey-navy">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-mckinsey-gray">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.edit') }}" class="mckinsey-nav-link">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();"
                                   class="mckinsey-nav-link">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>