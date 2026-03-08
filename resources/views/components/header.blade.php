<header x-data="{ mobileMenu: false }" class="text-white relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-24">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex-shrink-0 text-2xl font-bold text-white">
                Nan<span class="text-purple-500">Flex</span>
            </a>

            <!-- Navigation: Hidden on mobile -->
            <nav class="hidden md:flex space-x-10 bg-gray-800/50 backdrop-blur-md rounded-full px-6 py-4">
                <a href="{{ url('/') }}" class="hover:text-purple-500 transition">Home</a>
                <a href="#" class="hover:text-purple-500 transition">Movies</a>
                <a href="#" class="hover:text-purple-500 transition">Theaters</a>
                <a href="#" class="hover:text-purple-500 transition">Releases</a>
            </nav>

            <!-- Right Icons / Auth -->
            <div class="flex items-center space-x-4">

                <!-- Search Icon -->
                <button class="p-2 hover:bg-gray-700 rounded-full transition sm:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
                    </svg>
                </button>

                <!-- Auth Buttons -->
                @guest
                    <!-- Guest Buttons -->
                    <a href="{{ url('/login') }}"
                       class="bg-purple-500 hover:bg-purple-600 px-4 md:px-6 py-2 rounded-full transition text-sm md:text-base">
                        Login
                    </a>

                    <a href="{{ url('/login') }}"
                       class="hidden md:block border border-purple-500 px-4 py-2 rounded-full hover:bg-purple-500 transition duration-500 text-sm">
                        Register
                    </a>
                @endguest

                @auth
                    <!-- User Dropdown -->
                    <div x-data="{ userMenu: false }" class="relative">
                        <button @click="userMenu = !userMenu"
                                class="flex items-center space-x-2 hover:bg-gray-700 px-3 py-2 rounded-full transition">

                            <!-- Avatar -->
                            <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                            </div>

                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userMenu" x-cloak
                             @click.away="userMenu=false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute right-0 mt-3 w-40 bg-gray-800 rounded-lg shadow-lg overflow-hidden z-50">

                            <a href="#" class="block px-4 py-2 hover:bg-gray-700">Profile</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700">My Tickets</a>

                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button class="w-full text-left px-4 py-2 hover:bg-red-500">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <!-- Hamburger Menu Icon for Mobile -->
                <button @click="mobileMenu = !mobileMenu"
                        class="md:hidden p-2 hover:bg-gray-700 rounded-full transition focus:outline-none">
                    <svg x-show="!mobileMenu" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         @click.away="mobileMenu = false"
         class="md:hidden bg-gray-800/80 backdrop-blur-md rounded-b-lg z-40">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded hover:bg-gray-700 transition">Home</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700 transition">Movies</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700 transition">Theaters</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700 transition">Releases</a>

            @guest
                {{-- <a href="{{ url('/login') }}" class="block px-3 py-2 rounded hover:bg-purple-600 transition">Login</a> --}}
                <a href="{{ url('/register') }}" class="block px-3 py-2 rounded hover:bg-purple-600 transition">Register</a>
            @endguest

            @auth
                {{-- <span class="block px-3 py-2 text-gray-200 font-semibold">{{ Auth::user()->name }}</span> --}}
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-red-500 transition">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</header>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- x-cloak CSS to prevent flicker -->
<style>
[x-cloak] { display: none; }
</style>
