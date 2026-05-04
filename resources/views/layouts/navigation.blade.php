<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
                        <div style="background: linear-gradient(135deg, #2563eb, #7c3aed); width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.6rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
                            Q
                        </div>
                        <div class="flex flex-col">
                            <span style="font-size: 1.5rem; font-weight: 900; line-height: 1; background: linear-gradient(to right, #1e293b, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -1px;">
                                QUIZZO
                            </span>
                            <span style="font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px;">Academy</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" style="font-weight: 700; color: #475569;">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if(Auth::user()->is_admin)
                        <x-nav-link :href="route('admin.autofill')" style="font-weight: 700; color: #4f46e5;">
                            {{ __('Sync New Quiz') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-bold rounded-xl text-gray-500 bg-gray-50 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center gap-2">
                                <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                                
                                <div class="flex items-center">
                                    <span style="color: #1e293b; font-weight: 800;">{{ Auth::user()->name }}</span>
                                    
                                    @if(Auth::user()->is_admin)
                                        <span style="background: #dbeafe; color: #1e40af; font-size: 0.6rem; padding: 2px 10px; border-radius: 99px; margin-left: 8px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #bfdbfe;">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->is_admin)
                <x-responsive-nav-link :href="route('admin.autofill')">
                    {{ __('Sync New Quiz') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                @if(Auth::user()->is_admin)
                    <span style="background: #dbeafe; color: #1e40af; font-size: 0.6rem; padding: 2px 8px; border-radius: 99px; text-transform: uppercase; font-weight: 900;">Admin</span>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</nav>