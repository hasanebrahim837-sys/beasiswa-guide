<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" style="font-weight:bold; font-size:22px; color:#0f766e;">
                        Beasiswa<span style="color:#111827;">Guide</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>

                    <x-nav-link :href="route('scholarships.index')" :active="request()->routeIs('scholarships.index')">
                        Scholarships
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.assistance_requests.index')" :active="request()->routeIs('admin.assistance_requests.*')">
                                Requests
                            </x-nav-link>

                            <x-nav-link :href="route('admin.scholarships.index')" :active="request()->routeIs('admin.scholarships.*')">
                                Manage Scholarships
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" style="margin-right:15px; font-weight:bold; color:#0f766e;">
                        Login
                    </a>

                    <a href="{{ route('register') }}" style="font-weight:bold; color:#111827;">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>